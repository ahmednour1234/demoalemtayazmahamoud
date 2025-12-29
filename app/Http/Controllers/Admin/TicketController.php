<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Ticket, TicketAssignee, TicketComment, Admin, SystemLog};
use App\Enums\ApprovedStatus;
use Illuminate\Http\{Request};
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{Auth, DB, Notification};
use Brian2694\Toastr\Facades\Toastr;

class TicketController extends Controller
{
    /* =========================================================
     |                       Index (filters)
     * ========================================================= */
    public function index(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'tickets.index')) return $resp;

        $q = Ticket::query()
            ->with([
                'creator:id,name,email,branch_id,department_id',
                'approver:id,name,email',
                'resolver:id,name,email',
                'currentAssignee.admin:id,name,email,branch_id,department_id',
            ]);

        // نطاق الرؤية
        $this->applyVisibility($request, $q);

        // فلاتر
        $q->when($request->filled('q'), function ($qq) use ($request) {
            $term = trim($request->string('q'));
            $qq->where(function ($w) use ($term) {
                $w->where('title', 'like', "%{$term}%")
                  ->orWhere('code', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        });

        $q->when($request->filled('approved_status'), function ($qq) use ($request) {
            $val = $request->string('approved_status');
            if (in_array($val, [ApprovedStatus::PENDING->value, ApprovedStatus::APPROVED->value, ApprovedStatus::REJECTED->value])) {
                $qq->where('approved_status', $val);
            }
        });

        $q->when($request->filled('is_resolved'), function ($qq) use ($request) {
            $resolved = (int)$request->input('is_resolved') === 1;
            $qq->where('is_resolved', $resolved);
        });

        // المعيَّن الحالي
        $q->when($request->filled('assigned_admin_id'), function ($qq) use ($request) {
            $adminId = (int)$request->input('assigned_admin_id');
            $qq->whereExists(function ($sub) use ($adminId) {
                $sub->from('ticket_assignees as ta')
                    ->whereColumn('ta.ticket_id', 'tickets.id')
                    ->where('ta.is_active', 1)
                    ->where('ta.admin_id', $adminId);
            });
        });

        // منشئ التذكرة
        $q->when($request->filled('created_by'), fn($qq) => $qq->where('created_by', (int)$request->input('created_by')));

        // التاريخ
        if ($request->filled('date_from')) $q->whereDate('created_at', '>=', $request->date('date_from'));
        if ($request->filled('date_to'))   $q->whereDate('created_at', '<=', $request->date('date_to'));

        $tickets = $q->orderByDesc('created_at')->paginate(20)->withQueryString();

        $admins = Admin::query()->select('id', 'name', 'email')->orderBy('name')->get();

        return view('admin-views.tickets.index', [
            'tickets' => $tickets,
            'admins'  => $admins,
            'filters' => $request->all(),
        ]);
    }

    /* =========================================================
     |                       Show
     * ========================================================= */
    public function show(Request $request, int $id)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'tickets.show')) return $resp;

        $q = Ticket::query()
            ->with([
                'creator:id,name,email,branch_id,department_id',
                'approver:id,name,email',
                'resolver:id,name,email',
                'assignees.admin:id,name,email',
                'comments.admin:id,name,email',
            ])
            ->where('tickets.id', $id);

        $this->applyVisibility($request, $q);

        $ticket = $q->first();

        if (!$ticket) {
            Toastr::warning('غير مسموح لك بعرض هذه التذكرة أو غير موجودة.');
            return redirect()->back();
        }

        $this->log('tickets.view', 'tickets', $ticket->id, [], $request);

        return view('admin.tickets.show', compact('ticket'));
    }

    /* =========================================================
     |                       Create / Store
     * ========================================================= */
    public function create(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'tickets.create')) return $resp;
        return view('admin-views.tickets.create');
    }

    public function store(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'tickets.store')) return $resp;

        $data = $request->validate([
            'code'        => ['nullable', 'string', 'max:50', 'unique:tickets,code'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            // اختياري تعيين مباشر
            'assign_to'   => ['nullable', 'integer', 'exists:admins,id'],
        ]);

        $data['created_by']      = Auth::guard('admin')->id();
        $data['approved_status'] = ApprovedStatus::PENDING;
        $data['is_resolved']     = false;

        $ticket = DB::transaction(function () use ($data) {
            /** @var Ticket $ticket */
            $ticket = Ticket::create($data);

            if (!empty($data['assign_to'])) {
                // ألغِ أي تعيينات نشطة (احترازيًا لو تم الإنشاء عبر seed)
                $ticket->assignees()->where('is_active', true)->update([
                    'is_active'     => false,
                    'unassigned_at' => now(),
                ]);

                $ticket->assignees()->create([
                    'admin_id'             => (int)$data['assign_to'],
                    'assigned_by_admin_id' => Auth::guard('admin')->id(),
                    'is_active'            => true,
                    'assigned_at'          => now(),
                ]);

                $this->notifyAssignedTicket($ticket, null, (int)$data['assign_to']);
            }

            return $ticket;
        });

        $this->log('tickets.create', 'tickets', $ticket->id, ['code' => $ticket->code], $request);
        Toastr::success('تم إنشاء التذكرة بنجاح.');
        return redirect()->route('admin.tickets.show', $ticket->id);
    }

    /* =========================================================
     |                       Edit / Update
     * ========================================================= */
    public function edit(Request $request, int $id)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'tickets.edit')) return $resp;

        $q = Ticket::query()->where('id', $id);
        $this->applyVisibility($request, $q);
        $ticket = $q->first();

        if (!$ticket) {
            Toastr::warning('غير مسموح بالتعديل أو التذكرة غير موجودة.');
            return redirect()->back();
        }

        return view('admin-views.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, int $id)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'tickets.update')) return $resp;

        $q = Ticket::query()->where('id', $id);
        $this->applyVisibility($request, $q);
        /** @var Ticket|null $ticket */
        $ticket = $q->first();

        if (!$ticket) {
            Toastr::warning('غير مسموح بالتحديث أو التذكرة غير موجودة.');
            return redirect()->back();
        }

        $data = $request->validate([
            'code'        => ['nullable', 'string', 'max:50', 'unique:tickets,code,' . $ticket->id],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            // تحديث التعيين (اختياري)
            'assign_to'   => ['nullable', 'integer', 'exists:admins,id'],
            // تحديث حالة الموافقة/الحل (اختياري)
            'approved_status' => ['nullable', 'in:pending,approved,rejected'],
            'is_resolved'     => ['nullable', 'boolean'],
        ]);

        $meta = [];

        DB::transaction(function () use ($request, $ticket, $data, &$meta) {
            // تغييرات بسيطة
            $orig = $ticket->only(['code','title','description','approved_status','is_resolved']);
            $ticket->fill(collect($data)->only(['code','title','description'])->toArray())->save();

            // موافقة
            if (array_key_exists('approved_status', $data) && $data['approved_status'] !== null) {
                $new = ApprovedStatus::from($data['approved_status']);
                if ($new !== $ticket->approved_status) {
                    $ticket->forceFill([
                        'approved_status' => $new,
                        'approved_by'     => Auth::guard('admin')->id(),
                        'approved_at'     => now(),
                    ])->save();
                }
            }

            // حل/عدم حل
            if (array_key_exists('is_resolved', $data) && $data['is_resolved'] !== null) {
                $resolve = (bool)$data['is_resolved'];
                if ($resolve !== (bool)$ticket->is_resolved) {
                    if ($resolve) {
                        $ticket->forceFill([
                            'is_resolved' => true,
                            'resolved_by' => Auth::guard('admin')->id(),
                            'resolved_at' => now(),
                        ])->save();
                    } else {
                        $ticket->forceFill([
                            'is_resolved' => false,
                            'resolved_by' => null,
                            'resolved_at' => null,
                        ])->save();
                    }
                }
            }

            // تعيين
            if (!empty($data['assign_to'])) {
                $oldAssigneeId = $this->currentAssigneeId($ticket->id);
                $newAssigneeId = (int)$data['assign_to'];

                if ($oldAssigneeId !== $newAssigneeId) {
                    // إلغاء النشط
                    $ticket->assignees()->where('is_active', true)->update([
                        'is_active'     => false,
                        'unassigned_at' => now(),
                    ]);
                    // إنشاء تعيين جديد
                    $ticket->assignees()->create([
                        'admin_id'             => $newAssigneeId,
                        'assigned_by_admin_id' => Auth::guard('admin')->id(),
                        'is_active'            => true,
                        'assigned_at'          => now(),
                    ]);

                    $this->notifyAssignedTicket($ticket, $oldAssigneeId, $newAssigneeId);
                }
            }

            $meta = [
                'before' => $orig,
                'after'  => $ticket->only(['code','title','description','approved_status','is_resolved']),
            ];
        });

        $this->log('tickets.update', 'tickets', $ticket->id, $meta, $request);
        Toastr::success('تم تحديث التذكرة بنجاح.');
        return redirect()->route('admin.tickets.show', $ticket->id);
    }

    /* =========================================================
     |                       Destroy
     * ========================================================= */
    public function destroy(Request $request, int $id)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'tickets.destroy')) return $resp;

        $q = Ticket::query()->where('id', $id);
        $this->applyVisibility($request, $q);
        $ticket = $q->first();

        if (!$ticket) {
            Toastr::warning('غير مسموح بالحذف أو التذكرة غير موجودة.');
            return redirect()->back();
        }

        $ticketId = $ticket->id;

        DB::transaction(function () use ($ticket) {
            // سيتم حذف التعليقات/التعيينات بـ ON DELETE CASCADE لو مفعّلة في الـ FK
            $ticket->delete();
        });

        $this->log('tickets.destroy', 'tickets', $ticketId, [], $request);
        Toastr::success('تم حذف التذكرة.');
        return redirect()->route('admin.tickets.index');
    }

    /* =========================================================
     |                     Helpers & Permissions
     * ========================================================= */

    /** تسجيل نظامي */
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

    /** إشعار المعيَّن الجديد (لو فيه Notification: App\Notifications\TicketAssigned) */
    private function notifyAssignedTicket(Ticket $ticket, ?int $oldOwnerId, ?int $newOwnerId): void
    {
        if (!$newOwnerId) return;
        $owner = Admin::find($newOwnerId);
        if ($owner && class_exists(\App\Notifications\TicketAssigned::class)) {
            Notification::send($owner, new \App\Notifications\TicketAssigned($ticket));
        }
    }

    /** فحص صلاحيات بالدور */
    private function ensurePermissionOrBack(Request $request, string $permissionKey): ?RedirectResponse
    {
        $adminId = Auth::guard('admin')->id();
        $admin   = DB::table('admins')->where('id', $adminId)->first();

        if (!$admin) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        $role = DB::table('roles')->where('id', $admin->role_id)->first();
        if (!$role) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        $decoded = json_decode($role->data, true);
        if (is_string($decoded)) $decoded = json_decode($decoded, true);
        if (!is_array($decoded) || !in_array($permissionKey, $decoded)) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }

        return null; // OK
    }

    /**
     * تطبيق نطاق الرؤية للتذاكر:
     * - all: بلا قيود
     * - branch/department: منشئ التذكرة أو المعيَّن الحالي ضمن نفس الفرع/القسم
     * - manager_tree: منشئ/معيّن ضمن شجرة المرؤوسين
     * - team: ضمن فرق المستخدم (جدول team_members)
     * - self: منشئ التذكرة أو المعيّن الحالي = نفس المستخدم
     */
    private function applyVisibility(Request $request, $query)
    {
        $admin = Auth::guard('admin')->user();
        $role  = DB::table('roles')->where('id', $admin->role_id)->first();
        $perms = $role ? json_decode($role->data, true) : [];
        if (is_string($perms)) $perms = json_decode($perms, true);
        $perms = is_array($perms) ? $perms : [];

        if (in_array('scope.view.all', $perms)) {
            return $query; // لا قيود
        }

        // branch
        if (in_array('scope.view.branch', $perms) && isset($admin->branch_id)) {
            $branchId = $admin->branch_id;
            $query->where(function ($q) use ($branchId, $admin) {
                $q->where('created_by', $admin->id)
                  ->orWhereExists(function ($sub) use ($branchId) {
                      $sub->from('admins as ac')
                          ->whereColumn('ac.id', 'tickets.created_by')
                          ->where('ac.branch_id', $branchId);
                  })
                  ->orWhereExists(function ($sub) use ($branchId) {
                      $sub->from('ticket_assignees as ta')
                          ->join('admins as aa', 'aa.id', '=', 'ta.admin_id')
                          ->whereColumn('ta.ticket_id', 'tickets.id')
                          ->where('ta.is_active', 1)
                          ->where('aa.branch_id', $branchId);
                  });
            });
            return $query;
        }

        // department
        if (in_array('scope.view.department', $perms) && isset($admin->department_id)) {
            $deptId = $admin->department_id;
            $query->where(function ($q) use ($deptId, $admin) {
                $q->where('created_by', $admin->id)
                  ->orWhereExists(function ($sub) use ($deptId) {
                      $sub->from('admins as ac')
                          ->whereColumn('ac.id', 'tickets.created_by')
                          ->where('ac.department_id', $deptId);
                  })
                  ->orWhereExists(function ($sub) use ($deptId) {
                      $sub->from('ticket_assignees as ta')
                          ->join('admins as aa', 'aa.id', '=', 'ta.admin_id')
                          ->whereColumn('ta.ticket_id', 'tickets.id')
                          ->where('ta.is_active', 1)
                          ->where('aa.department_id', $deptId);
                  });
            });
            return $query;
        }

        // manager tree
        if (in_array('scope.view.manager_tree', $perms)) {
            $ids = $this->subordinateIds($admin->id);
            $query->where(function ($q) use ($admin, $ids) {
                $q->where('created_by', $admin->id)
                  ->orWhereIn('created_by', $ids)
                  ->orWhereExists(function ($sub) use ($ids) {
                      $sub->from('ticket_assignees as ta')
                          ->whereColumn('ta.ticket_id', 'tickets.id')
                          ->where('ta.is_active', 1)
                          ->whereIn('ta.admin_id', $ids);
                  });
            });
            return $query;
        }

        // team
        if (in_array('scope.view.team', $perms)) {
            $teamMemberAdminIds = DB::table('team_members')
                ->whereIn('team_id', function ($q) use ($admin) {
                    $q->from('team_members')->select('team_id')->where('admin_id', $admin->id);
                })->pluck('admin_id')->all();

            $query->where(function ($q) use ($admin, $teamMemberAdminIds) {
                $q->where('created_by', $admin->id)
                  ->orWhereIn('created_by', $teamMemberAdminIds)
                  ->orWhereExists(function ($sub) use ($teamMemberAdminIds) {
                      $sub->from('ticket_assignees as ta')
                          ->whereColumn('ta.ticket_id', 'tickets.id')
                          ->where('ta.is_active', 1)
                          ->whereIn('ta.admin_id', $teamMemberAdminIds);
                  });
            });
            return $query;
        }

        // self (افتراضي)
        if (in_array('scope.view.self', $perms)) {
            $query->where(function ($q) use ($admin) {
                $q->where('created_by', $admin->id)
                  ->orWhereExists(function ($sub) use ($admin) {
                      $sub->from('ticket_assignees as ta')
                          ->whereColumn('ta.ticket_id', 'tickets.id')
                          ->where('ta.is_active', 1)
                          ->where('ta.admin_id', $admin->id);
                  });
            });
        }

        return $query;
    }

    /** إرجاع ID المعيَّن الحالي للتذكرة إن وجد */
    private function currentAssigneeId(int $ticketId): ?int
    {
        $row = DB::table('ticket_assignees')
            ->select('admin_id')
            ->where('ticket_id', $ticketId)
            ->where('is_active', 1)
            ->orderByDesc('assigned_at')
            ->first();

        return $row?->admin_id;
    }

    /** شجرة المرؤوسين (BFS بسيط حتى 10 مستويات) */
    private function subordinateIds(int $managerId, int $maxDepth = 10): array
    {
        $visited = [];
        $level   = [$managerId];
        for ($d = 0; $d < $maxDepth; $d++) {
            $children = DB::table('admins')->whereIn('manager_id', $level)->pluck('id')->all();
            $children = array_values(array_diff($children, $visited));
            if (empty($children)) break;
            $visited = array_unique(array_merge($visited, $children));
            $level   = $children;
        }
        return $visited;
    }
    // داخل App\Http\Controllers\Dashboard\TicketController


public function commentStore(Request $request, int $ticketId)
{
    if ($resp = $this->ensurePermissionOrBack($request, 'tickets.comments.store')) return $resp;

    $ticketQ = \App\Models\Ticket::query()->where('id', $ticketId);
    $this->applyVisibility($request, $ticketQ);
    $ticket = $ticketQ->firstOrFail();

    $data = $request->validate(['body' => ['required','string']]);

    $comment = $ticket->comments()->create([
        'admin_id' => auth('admin')->id(),
        'body'     => $data['body'],
    ]);

    $this->log('tickets.comment.create', 'ticket_comments', $comment->id, ['ticket_id'=>$ticket->id], $request);
    \Brian2694\Toastr\Facades\Toastr::success('تم إضافة التعليق.');
    return redirect()->route('admin.tickets.show', $ticket->id) . '#comments';
}

public function commentDestroy(Request $request, int $ticketId, int $commentId)
{
    if ($resp = $this->ensurePermissionOrBack($request, 'tickets.comments.destroy')) return $resp;

    $comment = TicketComment::with('ticket')->where('id', $commentId)->where('ticket_id', $ticketId)->firstOrFail();

    // تأكيد الرؤية
    $ticketQ = \App\Models\Ticket::query()->where('id', $comment->ticket_id);
    $this->applyVisibility($request, $ticketQ);
    if (!$ticketQ->exists()) {
        \Brian2694\Toastr\Facades\Toastr::warning('غير مسموح لك.');
        return redirect()->back();
    }

    $comment->delete();
    $this->log('tickets.comment.destroy', 'ticket_comments', $commentId, ['ticket_id'=>$ticketId], $request);
    \Brian2694\Toastr\Facades\Toastr::success('تم حذف التعليق.');
    return redirect()->route('admin.tickets.show', $ticketId) . '#comments';
}

}
