<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\StoreLeadRequest;
use App\Http\Requests\Admin\Lead\UpdateLeadRequest;
use App\Http\Requests\Admin\Lead\ImportLeadsRequest;
use App\Models\{Lead, LeadStatus, LeadSource, Admin, SystemLog};
use App\Models\{Project, Task};
use App\Models\TaskAssignee;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Notification;
use Rap2hpoutre\FastExcel\FastExcel;

// Notifications (جهّزها كما بالأسفل)
use App\Notifications\LeadAssigned;
use App\Notifications\LeadTransferred;
use App\Notifications\TaskAssigned;

class LeadController extends Controller
{
    /* =========================
     |  Index / List
     |=========================*/
    public function index(Request $request)
    {
        $this->authorizeAbility('leads.index');

        $q = Lead::query()->with(['status','source','owner']);
        $q = $this->applyVisibility($request, $q); // ← سكوب الرؤية

        if ($s = $request->string('search')->toString()) {
            $q->where(function ($qq) use ($s) {
                $qq->where('company_name','like',"%$s%")
                   ->orWhere('contact_name','like',"%$s%")
                   ->orWhere('email','like',"%$s%")
                   ->orWhere('phone','like',"%$s%");
            });
        }
        if ($request->filled('status_id')) $q->where('status_id', (int)$request->status_id);
        if ($request->filled('source_id')) $q->where('source_id', (int)$request->source_id);
        if ($request->filled('owner_id'))  $q->where('owner_id',  (int)$request->owner_id);
        if ($request->has('archived') && $request->archived !== '') {
            $q->where('is_archived', (int)$request->boolean('archived'));
        }

        $leads = $q->orderByDesc('id')->paginate(20)->withQueryString();

        return view('admin-views.leads.index', [
            'leads'    => $leads,
            'filters'  => $request->only(['search','status_id','source_id','owner_id','archived']),
            'statuses' => LeadStatus::orderBy('sort_order')->get(),
            'sources'  => LeadSource::orderBy('name')->get(),
            'admins'   => Admin::orderBy('email')->get(),
        ]);
    }

    public function create()
    {
        $this->authorizeAbility('leads.store');

        return view('admin-views.leads.create', [
            'statuses' => LeadStatus::orderBy('sort_order')->get(),
            'sources'  => LeadSource::orderBy('name')->get(),
            'admins'   => Admin::orderBy('email')->get(),
        ]);
    }

    public function store(StoreLeadRequest $request)
    {
        $this->authorizeAbility('leads.store');

        $data = $request->validated();
        $data['owner_id'] = $data['owner_id'] ?? auth('admin')->id();
        $data['created_by_admin_id'] = auth('admin')->id();

        $lead = DB::transaction(function () use ($data, $request) {
            $lead = Lead::create($data);

            if (Schema::hasColumn('leads','phone_normalized')) {
                $lead->phone_normalized = $this->normalizePhone($lead->country_code, $lead->phone);
                $lead->save();
            }

            if (method_exists($lead, 'syncCustomFields')) {
                $lead->syncCustomFields($request->input('custom_fields', []));
            }

            $this->log('lead.created', 'leads', $lead->id, [
                'after' => $lead->toArray(),
            ], $request);

            return $lead;
        });

        Toastr::success('تم إنشاء العميل المحتمل بنجاح');
        return redirect()->route('admin.leads.edit', $lead);
    }

    public function edit(Lead $lead)
    {
        $this->authorizeAbility('leads.update');
        $this->guardViewRecord($lead);

        return view('admin-views.leads.edit', [
            'lead'     => $lead->load(['status','source','owner']),
            'statuses' => LeadStatus::orderBy('sort_order')->get(),
            'sources'  => LeadSource::orderBy('name')->get(),
            'admins'   => Admin::orderBy('email')->get(),
        ]);
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $this->authorizeAbility('leads.update');
        $this->guardViewRecord($lead);

        $before = $lead->replicate()->toArray();
        $data   = $request->validated();

        DB::transaction(function () use ($lead, $before, $data, $request) {
            $oldOwnerId = $lead->owner_id;

            $lead->update($data);

            if (Schema::hasColumn('leads','phone_normalized')) {
                $lead->phone_normalized = $this->normalizePhone($lead->country_code, $lead->phone);
                $lead->save();
            }

            if (method_exists($lead, 'syncCustomFields')) {
                $lead->syncCustomFields($request->input('custom_fields', []));
            }

            $this->log('lead.updated', 'leads', $lead->id, [
                'before'  => $before,
                'after'   => $lead->toArray(),
                'changes' => $lead->getChanges(),
            ], $request);

            $newOwnerId = $lead->owner_id;
            if ($newOwnerId && $newOwnerId != $oldOwnerId) {
            }
        });

        Toastr::success('تم تحديث العميل المحتمل بنجاح');
        return redirect()->route('admin.leads.index');
    }

    public function destroy(Request $request, Lead $lead)
    {
        $this->authorizeAbility('leads.destroy');
        $this->guardViewRecord($lead);

        DB::transaction(function () use ($lead, $request) {
            $snapshot = $lead->toArray();
            $id = $lead->id;

            if (method_exists($lead, 'customFieldValues')) {
                $lead->customFieldValues()->delete();
            }

            $lead->delete();

            $this->log('lead.deleted', 'leads', $id, [
                'before' => $snapshot,
            ], $request);
        });

        Toastr::success('تم حذف العميل المحتمل');
        return redirect()->route('admin.leads.index');
    }

    public function archive(Request $request, Lead $lead)
    {
        $this->authorizeAbility('leads.update');
        $this->guardViewRecord($lead);

        $before = $lead->replicate()->toArray();
        $lead->is_archived = (bool)$request->boolean('archived', !$lead->is_archived);
        $lead->save();

        $this->log('lead.archive_toggled', 'leads', $lead->id, [
            'before' => $before,
            'after'  => $lead->toArray(),
        ], $request);

        Toastr::success('تم تحديث الأرشفة');
        return back();
    }

    public function show(Lead $lead)
    {
        $this->authorizeAbility('leads.show');
        $this->guardViewRecord($lead);

        $lead->load([
            'status','source','owner',
            'callLogs.outcome','callLogs.admin',
            'notes.admin',
            'customFieldValues.customField',
        ]);

        $logs = SystemLog::query()
            ->with('actor')
            ->where(function($q) use ($lead){
                $q->where('lead_id', $lead->id)
                  ->orWhere(function($q) use ($lead){
                      $q->whereIn('table_name', ['call_logs','lead_notes','leads'])
                        ->where(function($w) use ($lead){
                            $w->where('meta->after->lead_id', $lead->id)
                              ->orWhere('meta->before->lead_id', $lead->id)
                              ->orWhere('record_id', $lead->id);
                        });
                  });
            })
            ->orderByDesc('created_at')
            ->limit(120)
            ->get();

        return view('admin-views.leads.show', [
            'lead' => $lead,
            'logs' => $logs,
        ]);
    }

    public function pdfReport(Lead $lead)
    {
        $this->authorizeAbility('leads.show');
        $this->guardViewRecord($lead);

        $lead->loadMissing([
            'status','source','owner',
            'callLogs.outcome','callLogs.admin',
            'notes.admin',
            'customFieldValues.customField',
        ]);

        $logs = SystemLog::query()
            ->with('actor')
            ->where(function($q) use ($lead){
                $q->where('lead_id', $lead->id)
                  ->orWhere(function($q) use ($lead){
                      $q->whereIn('table_name', ['call_logs','lead_notes','leads'])
                        ->where(function($w) use ($lead){
                            $w->where('meta->after->lead_id', $lead->id)
                              ->orWhere('meta->before->lead_id', $lead->id)
                              ->orWhere('record_id', $lead->id);
                        });
                  });
            })
            ->orderBy('created_at')
            ->get();

        $pdf = Pdf::loadView('admin-views.leads.report_pdf', [
                'lead' => $lead,
                'logs' => $logs,
            ])
            ->setPaper('a4')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'Amiri',
            ]);

        return $pdf->download("lead_{$lead->id}_report.pdf");
    }

    /* =========================
     |  Export / Template / Import
     |=========================*/
    public function export(Request $request)
    {
        $this->authorizeAbility('leads.index');

        $filters = $request->only(['search','status_id','source_id','owner_id','archived']);

        $q = Lead::query()->with(['status','source','owner']);
        $q = $this->applyVisibility($request, $q);

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $q->where(function ($qq) use ($s) {
                $qq->where('company_name','like',"%$s%")
                   ->orWhere('contact_name','like',"%$s%")
                   ->orWhere('email','like',"%$s%")
                   ->orWhere('phone','like',"%$s%");
            });
        }
        if (!empty($filters['status_id'])) $q->where('status_id', (int)$filters['status_id']);
        if (!empty($filters['source_id'])) $q->where('source_id', (int)$filters['source_id']);
        if (!empty($filters['owner_id']))  $q->where('owner_id',  (int)$filters['owner_id']);
        if (isset($filters['archived']) && $filters['archived'] !== '') {
            $q->where('is_archived', (int)(bool)$filters['archived']);
        }

        $rows = $q->orderByDesc('id')->get()->map(function (Lead $lead) {
            return [
                'ID'               => $lead->id,
                'Company'          => $lead->company_name,
                'Contact'          => $lead->contact_name,
                'Email'            => $lead->email,
                'Country Code'     => $lead->country_code,
                'Phone'            => $lead->phone,
                'Phone Normalized' => Schema::hasColumn('leads','phone_normalized')
                    ? ($lead->phone_normalized ?? $this->normalizePhone($lead->country_code, $lead->phone))
                    : $this->normalizePhone($lead->country_code, $lead->phone),
                'WhatsApp'         => $lead->whatsapp,
                'Potential Value'  => $lead->potential_value,
                'Currency'         => $lead->currency,
                'Rating'           => $lead->rating,
                'Status Code'      => optional($lead->status)->code,
                'Source Code'      => optional($lead->source)->code,
                'Owner Email'      => optional($lead->owner)->email,
                'Last Contact At'  => optional($lead->last_contact_at)?->toDateTimeString(),
                'Next Action At'   => optional($lead->next_action_at)?->toDateTimeString(),
                'Notes'            => $lead->pipeline_notes,
                'Created At'       => optional($lead->created_at)?->toDateTimeString(),
            ];
        });

        return (new FastExcel($rows))->download('leads.xlsx');
    }

    public function template()
    {
        $this->authorizeAbility('leads.index');

        $template = collect([[
            'company'         => 'ACME LLC',
            'contact'         => 'Ahmed Ali',
            'email'           => 'ahmed@example.com',
            'country_code'    => '+20',
            'phone'           => '01000111222',
            'whatsapp'        => '01000111222',
            'potential_value' => 50000,
            'currency'        => 'EGP',
            'rating'          => 4,
            'status_code'     => 'new',
            'source_code'     => 'ads',
            'owner_email'     => 'owner@example.com',
            'last_contact_at' => '2025-08-01 10:00:00',
            'next_action_at'  => '2025-08-10 14:00:00',
            'notes'           => 'ملاحظة تجريبية',
        ]]);

        return (new FastExcel($template))->download('leads_template.xlsx');
    }

    public function importView()
    {
        $this->authorizeAbility('leads.store');

        return view('admin-views.leads.import', [
            'admins' => Admin::orderBy('email')->get(),
        ]);
    }

    public function import(ImportLeadsRequest $request)
    {
        $this->authorizeAbility('leads.store');

        $file = $request->file('file');

        $eligibleAdminIds = $request->boolean('distribute')
            ? array_values(array_unique(array_filter($request->input('admin_ids', []))))
            : [];

        if (empty($eligibleAdminIds)) {
            $eligibleAdminIds = Admin::orderBy('id')->pluck('id')->all();
        }

        $defaultOwnerId   = $request->input('default_owner');
        $createdByAdminId = auth('admin')->id();

        $statusMap   = LeadStatus::pluck('id','code')->mapWithKeys(fn($id,$c)=>[strtolower(trim($c))=>$id])->all();
        $sourceMap   = LeadSource::pluck('id','code')->mapWithKeys(fn($id,$c)=>[strtolower(trim($c))=>$id])->all();
        $adminByMail = Admin::pluck('id','email')->mapWithKeys(fn($id,$m)=>[strtolower(trim($m))=>$id])->all();

        $hasPhoneNormalized = Schema::hasColumn('leads','phone_normalized');

        $rrIndex = 0;
        $counters = ['created'=>0,'updated'=>0,'skipped'=>0];

        (new FastExcel)->import($file, function (array $row) use (
            $defaultOwnerId, $createdByAdminId, $eligibleAdminIds, &$rrIndex,
            $statusMap, $sourceMap, $adminByMail, $hasPhoneNormalized, &$counters
        ) {
            $country = trim((string)($row['country_code'] ?? $row['Country Code'] ?? ''));
            $phone   = trim((string)($row['phone'] ?? $row['Phone'] ?? ''));

            if (!$country || !$phone) { $counters['skipped']++; return null; }

            $norm    = $this->normalizePhone($country, $phone);

            $statusCode = strtolower(trim((string)($row['status_code'] ?? $row['Status Code'] ?? '')));
            $sourceCode = strtolower(trim((string)($row['source_code'] ?? $row['Source Code'] ?? '')));
            $ownerEmail = strtolower(trim((string)($row['owner_email'] ?? $row['Owner Email'] ?? '')));

            $statusId = $statusCode && isset($statusMap[$statusCode]) ? $statusMap[$statusCode] : null;
            $sourceId = $sourceCode && isset($sourceMap[$sourceCode]) ? $sourceMap[$sourceCode] : null;

            $ownerId  = $ownerEmail && isset($adminByMail[$ownerEmail]) ? $adminByMail[$ownerEmail] : null;
            if (!$ownerId) $ownerId = $defaultOwnerId ?: $this->rrNextOwnerId($eligibleAdminIds, $rrIndex);

            $data = [
                'owner_id'            => $ownerId,
                'created_by_admin_id' => $createdByAdminId,
                'status_id'           => $statusId,
                'source_id'           => $sourceId,
                'company_name'        => $row['company'] ?? $row['Company'] ?? null,
                'contact_name'        => $row['contact'] ?? $row['Contact'] ?? null,
                'email'               => $row['email'] ?? $row['Email'] ?? null,
                'country_code'        => $country,
                'phone'               => $phone,
                'whatsapp'            => $row['whatsapp'] ?? $row['WhatsApp'] ?? null,
                'potential_value'     => $row['potential_value'] ?? $row['Potential Value'] ?? null,
                'currency'            => $row['currency'] ?? $row['Currency'] ?? null,
                'rating'              => $row['rating'] ?? $row['Rating'] ?? null,
                'pipeline_notes'      => $row['notes'] ?? $row['Notes'] ?? null,
                'last_contact_at'     => $this->parseDateTime($row['last_contact_at'] ?? $row['Last Contact At'] ?? null),
                'next_action_at'      => $this->parseDateTime($row['next_action_at'] ?? $row['Next Action At'] ?? null),
            ];

            $existing = $hasPhoneNormalized
                ? Lead::where('phone_normalized', $norm)->first()
                : Lead::where('country_code', $country)->where('phone', $phone)->first();

            if ($existing) {
                $oldOwnerId = $existing->owner_id;

                $existing->fill($data);
                if ($hasPhoneNormalized) $existing->phone_normalized = $norm;
                $existing->save();
                $counters['updated']++;

                if ($existing->owner_id && $existing->owner_id != $oldOwnerId) {
                    $this->notifyTransferred($existing, $oldOwnerId, $existing->owner_id);
                }
                return null;
            }

            $lead = new Lead($data);
            if ($hasPhoneNormalized) $lead->phone_normalized = $norm;
            $lead->save();
            $counters['created']++;

            $this->notifyAssigned($lead, null, $lead->owner_id);
            return null;
        });

        Toastr::success("تم الاستيراد بنجاح: مضافة {$counters['created']}, محدَّثة {$counters['updated']}, متخطاة {$counters['skipped']}.");
        return redirect()->route('admin.leads.index');
    }

    public function autoAssign(Request $request)
    {
        $this->authorizeAbility('leads.update');

        $adminIdsParam = $request->input('admin_ids', []);
        $admins = !empty($adminIdsParam)
            ? Admin::whereIn('id', $adminIdsParam)->pluck('id')->all()
            : Admin::where('is_active',1)->orderBy('id')->pluck('id')->all();

        if (empty($admins)) {
            Toastr::error('لا يوجد إداريون متاحون للتوزيع.');
            return back();
        }

        $unassigned = Lead::whereNull('owner_id')->orderBy('id')->get();
        $i = 0;

        DB::transaction(function () use ($unassigned, $admins, &$i) {
            foreach ($unassigned as $lead) {
                $newOwnerId = $admins[$i % count($admins)];
                $i++;

                Lead::where('id', $lead->id)->update(['owner_id' => $newOwnerId]);

                $lead->owner_id = $newOwnerId;
                $this->notifyAssigned($lead, null, $newOwnerId);
            }
        });

        Toastr::success('تم توزيع العملاء غير المعيّنين بالتساوي.');
        return back();
    }

    /* =========================
     |  Conversions
     |=========================*/

    // Lead → Project (Validation حسب سكيمتك)
    public function convertToProject(Request $request, Lead $lead)
    {
        $this->authorizeAbility('leads.update');
        $this->guardViewRecord($lead);

        $data = $request->validate([
            'name'       => ['required','string','max:191'],
            'code'       => ['required','string','max:64','unique:projects,code'],
            'description'=> ['nullable','string'],
            'status_id'  => ['nullable','exists:statuses,id'],
            'owner_id'   => ['required','exists:admins,id'],
            'lead_id'    => ['nullable','exists:leads,id'],
            'priority'   => ['required','in:low,medium,high,urgent'],
            'start_date' => ['nullable','date'],
            'due_date'   => ['nullable','date','after_or_equal:start_date'],
            'active'     => ['nullable','boolean'],
        ]);

        $project = DB::transaction(function () use ($lead, $data, $request) {
            $project = Project::create([
                'name'        => $data['name'],
                'code'        => $data['code'],
                'description' => $data['description'] ?? $lead->pipeline_notes,
                'status_id'   => $data['status_id'] ?? null,
                'owner_id'    => $data['owner_id'],
                'lead_id'     => $data['lead_id'] ?? $lead->id,
                'priority'    => $data['priority'],
                'start_date'  => $data['start_date'] ?? now(),
                'due_date'    => $data['due_date'] ?? null,
                'active'      => (bool)($data['active'] ?? true),
                'client_name' => $lead->contact_name ?? $lead->company_name,
                'client_email'=> $lead->email,
                'client_phone'=> $lead->phone,
                'budget'      => $lead->potential_value,
                'currency'    => $lead->currency,
                'created_by_admin_id' => auth('admin')->id(),
            ]);

            $this->log('lead.converted_to_project', 'projects', $project->id, [
                'from_lead_id' => $lead->id,
                'project'      => $project->toArray(),
            ], $request);

            // إشعار مالك المشروع الجديد (اختياري)
            if ($project->owner_id) {
                $owner = Admin::find($project->owner_id);
                if ($owner) Notification::send($owner, new LeadAssigned($lead));
            }

            return $project;
        });

        Toastr::success('تم تحويل الـ Lead إلى مشروع بنجاح.');
        return redirect()->route('admin.projects.show', $project);
    }

    // Lead → Task (Validation + assignees loop كما أرسلت)
    public function convertToTask(Request $request, Lead $lead)
    {
        $this->authorizeAbility('leads.update');
        $this->guardViewRecord($lead);

        $data = $request->validate([
            'project_id'        => ['nullable','exists:projects,id'],
            'lead_id'           => ['nullable','exists:leads,id'],
            'title'             => ['required','string','max:191'],
            'description'       => ['nullable','string'],
            'status_id'         => ['nullable','exists:statuses,id'],
            'priority'          => ['required','in:low,medium,high,urgent'],
            'start_at'          => ['nullable','date'],
            'due_at'            => ['nullable','date','after_or_equal:start_at'],
            'estimated_minutes' => ['nullable','integer','min:0'],
            'approval_required' => ['nullable','boolean'],
            'active'            => ['nullable','boolean'],
            'assignees'         => ['nullable','array'],
            'assignees.*'       => ['exists:admins,id'],
        ]);

        $task = DB::transaction(function () use ($lead, $data, $request) {
            $task = Task::create([
                'project_id'        => $data['project_id'] ?? null,
                'lead_id'           => $data['lead_id'] ?? $lead->id,
                'title'             => $data['title'],
                'description'       => $data['description'] ?? $lead->pipeline_notes,
                'status_id'         => $data['status_id'] ?? null,
                'priority'          => $data['priority'],
                'start_at'          => $data['start_at'] ?? now(),
                'due_at'            => $data['due_at'] ?? null,
                'estimated_minutes' => $data['estimated_minutes'] ?? null,
                'approval_required' => (bool)($data['approval_required'] ?? false),
                'active'            => (bool)($data['active'] ?? true),
                'created_by_admin_id' => Auth::guard('admin')->id(),
            ]);

            // Loop كما أرسلت + منع تكرار نفس (task_id, admin_id)
            if (!empty($data['assignees'])) {
                $uniqueAssignees = array_values(array_unique($data['assignees']));
                foreach ($uniqueAssignees as $uid) {
                    $exists = TaskAssignee::where('task_id', $task->id)
                        ->where('admin_id', $uid)->exists();
                    if ($exists) continue;

                    TaskAssignee::create([
                        'task_id'     => $task->id,
                        'admin_id'    => $uid,
                        'role'        => TaskAssignee::ROLE_ASSIGNEE ?? 'assignee',
                        'priority'    => $task->priority,
                        'due_at'      => $task->due_at,
                        'assigned_by' => Auth::guard('admin')->id(),
                    ]);

                    // إشعار المُكلَّف
                    $assignee = Admin::find($uid);
                    if ($assignee) {
                        Notification::send($assignee, new TaskAssigned($task, $lead));
                    }
                }
            }

            $this->log('lead.converted_to_task', 'tasks', $task->id, [
                'from_lead_id' => $lead->id,
                'task'         => $task->toArray(),
                'assignees'    => $data['assignees'] ?? [],
            ], $request);

            return $task;
        });

        Toastr::success('تم تحويل الـ Lead إلى مهمّة بنجاح.');
        return redirect()->route('admin.tasks.show', $task);
    }

    /* =========================
     |  Visibility / Auth / Logs
     |=========================*/

    private function authorizeAbility(string $ability): void
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) { Toastr::warning('غير مسموح لك! كلم المدير.'); abort(403); }

        $role = DB::table('roles')->where('id', $admin->role_id)->first();
        if (!$role) { Toastr::warning('غير مسموح لك! كلم المدير.'); abort(403); }

        $perms = $role ? json_decode($role->data, true) : [];
        if (is_string($perms)) $perms = json_decode($perms, true);
        $perms = is_array($perms) ? $perms : [];

        if (!in_array($ability, $perms)) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            abort(403);
        }
    }

    // سكوب الرؤية كما أرسلته حرفيًا (مع تعديلات طفيفة للسلامة)
private function applyVisibility(Request $request, $query)
{
    $admin = Auth::guard('admin')->user();
    $role  = DB::table('roles')->where('id', $admin->role_id)->first();

    $perms = $role ? json_decode($role->data, true) : [];
    if (is_string($perms)) $perms = json_decode($perms, true);
    $perms = is_array($perms) ? $perms : [];

    // يرى الكل
    if (in_array('scope.view.all', $perms)) {
        return $query;
    }

    // فرع
    if (in_array('scope.view.branch', $perms) && isset($admin->branch_id)) {
        $query->where(function ($q) use ($admin) {
            $q->where('owner_id', $admin->id)
              ->orWhere('created_by_admin_id', $admin->id)
              // ملاك بنفس الفرع
              ->orWhereHas('owner', fn($qq) => $qq->where('branch_id', $admin->branch_id))
              // مكلّف به عبر lead_assignments → admins.branch_id
              ->orWhereHas('assignees', fn($qq) => $qq->where('admins.branch_id', $admin->branch_id));
        });
        return $query;
    }

    // قسم
    if (in_array('scope.view.department', $perms) && isset($admin->department_id)) {
        $query->where(function ($q) use ($admin) {
            $q->where('owner_id', $admin->id)
              ->orWhere('created_by_admin_id', $admin->id)
              ->orWhereHas('owner', fn($qq) => $qq->where('department_id', $admin->department_id))
              ->orWhereHas('assignees', fn($qq) => $qq->where('admins.department_id', $admin->department_id));
        });
        return $query;
    }

    // شجرة المدير (تقريبي)
    if (in_array('scope.view.manager_tree', $perms)) {
        $ids = $this->subordinateIds($admin->id);
        $query->where(function ($q) use ($admin, $ids) {
            $q->where('owner_id', $admin->id)
              ->orWhere('created_by_admin_id', $admin->id)
              ->orWhereIn('owner_id', $ids)
              ->orWhereHas('assignees', fn($qq) => $qq->whereIn('admins.id', $ids));
        });
        return $query;
    }

    // self (الافتراضي)
    if (in_array('scope.view.self', $perms)) {
        $query->where(function ($q) use ($admin) {
            $q->where('owner_id', $admin->id)
              ->orWhere('created_by_admin_id', $admin->id)
              ->orWhereHas('assignees', fn($qq) => $qq->where('admins.id', $admin->id));
        });
    }

    return $query;
}


    private function subordinateIds(int $managerId): array
    {
        // TODO: استبدلها بمنطق شجرتك الحقيقي (recursive CTE أو path)
        return DB::table('admins')->where('manager_id', $managerId)->pluck('id')->all();
    }

    private function guardViewRecord(Lead $lead): void
    {
        $admin = Auth::guard('admin')->user();
        $role  = DB::table('roles')->where('id', $admin->role_id)->first();
        $perms = $role ? json_decode($role->data, true) : [];
        if (is_string($perms)) $perms = json_decode($perms, true);
        $perms = is_array($perms) ? $perms : [];

        if (in_array('scope.view.all', $perms)) return;

        $allowed = false;

        if (in_array('scope.view.self', $perms)) {
            $allowed = $allowed || ($lead->owner_id == $admin->id);
        }
        if (in_array('scope.view.branch', $perms) && isset($admin->branch_id)) {
            $allowed = $allowed ||
                ($lead->owner && $lead->owner->branch_id == $admin->branch_id);
        }
        if (in_array('scope.view.department', $perms) && isset($admin->department_id)) {
            $allowed = $allowed ||
                ($lead->owner && $lead->owner->department_id == $admin->department_id);
        }
        // manager_tree: يسمح لو المالك ضمن شجرتي
        if (in_array('scope.view.manager_tree', $perms)) {
            $ids = $this->subordinateIds($admin->id);
            $allowed = $allowed || in_array($lead->owner_id, $ids) || ($lead->owner_id == $admin->id);
        }
        // team: لو عندك تيمات، تقدر توسّع نفس فكرة applyVisibility

        if (!$allowed) {
            Toastr::warning('غير مسموح لك بعرض هذا السجل.');
            abort(403);
        }
    }

    private function log(string $action, ?string $table, ?int $recordId, array $meta, Request $request): void
    {
        SystemLog::create([
            'actor_admin_id' => auth('admin')->id(),
            'action'         => $action,
            'table_name'     => $table,
            'record_id'      => $recordId,
            'lead_id'        => $table === 'leads' ? $recordId : ($meta['from_lead_id'] ?? null),
            'ip_address'     => $request->ip(),
            'user_agent'     => substr((string)$request->userAgent(), 0, 255),
            'meta'           => $meta,
            'created_at'     => now()->setTimezone('UTC'),
        ]);
    }

    private function normalizePhone(?string $cc, ?string $ph): string
    {
        $cc = trim((string)$cc);
        $ph = preg_replace('/\D+/', '', (string)$ph) ?: '';
        return trim($cc.' '.$ph);
    }

    private function parseDateTime($value): ?string
    {
        if (empty($value)) return null;
        try {
            return date('Y-m-d H:i:s', strtotime((string)$value));
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function rrNextOwnerId(array $eligibleAdminIds, int &$index): ?int
    {
        if (empty($eligibleAdminIds)) return null;
        $id = $eligibleAdminIds[$index % count($eligibleAdminIds)];
        $index++;
        return $id;
    }

    /* =========================
     |  Notifications helpers
     |=========================*/

    private function notifyAssigned(Lead $lead, ?int $oldOwnerId, ?int $newOwnerId): void
    {
        if (!$newOwnerId) return;
        $owner = Admin::find($newOwnerId);
        if ($owner) Notification::send($owner, new LeadAssigned($lead));
    }

    private function notifyTransferred(Lead $lead, ?int $oldOwnerId, ?int $newOwnerId): void
    {
        if ($oldOwnerId && $newOwnerId && $newOwnerId != $oldOwnerId) {
            $old = Admin::find($oldOwnerId);
            $new = Admin::find($newOwnerId);

            if ($new) Notification::send($new, new LeadAssigned($lead));
            if ($old) Notification::send($old, new LeadTransferred($lead, $old, $new));
        }
    }
}
