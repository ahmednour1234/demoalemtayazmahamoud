<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    CallLog,
    CallOutcome,
    Lead,
    Admin,
    SystemLog,
    CustomField
};
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;

class CallLogController extends Controller
{
    public function index(Request $request)
    {
           $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("call_logs.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $q = CallLog::query()->with(['lead','admin','outcome']);
        $this->applyFilters($request, $q);

        $perPage = max(10, min((int)$request->query('per_page', 20), 200));
        $logs = $q->orderByDesc('started_at')->orderByDesc('id')->paginate($perPage)->withQueryString();

        return view('admin-views.call_logs.index', [
            'logs'     => $logs,
            'filters'  => $request->only([
                'search','outcome_id','admin_id',
                'started_from','started_to','ended_from','ended_to',
                'direction','channel'
            ]),
            'outcomes' => CallOutcome::orderBy('sort_order')->get(),
            'admins'   => Admin::orderBy('email')->get(),
        ]);
    }

    public function create()
    {
          $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("call_logs.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        // (اختياري) لو حابب تستخدم نفس التجميعة في الفورم
        $cfDefs = $this->customFieldDefs();

        return view('admin-views.call_logs.create', [
            'leads'          => Lead::orderByDesc('id')->limit(200)->get(),
            'outcomes'       => CallOutcome::where('is_active',1)->orderBy('sort_order')->get(),
            'admins'         => Admin::orderBy('email')->get(),
            'defaultAdminId' => auth('admin')->id(),
            // (اختياري للفورم إن كنت بتبنيه يدويًا)
            'cfDefs'         => $cfDefs,
            'cfValues'       => [],
        ]);
    }

    public function store(Request $request)
    {
          $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("call_logs.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $data = $this->validatePayload($request);
        $data['admin_id'] = $data['admin_id'] ?? auth('admin')->id();
        $this->normalizeTiming($data);

        DB::transaction(function () use ($data, $request) {
            /** @var CallLog $log */
            $log = CallLog::create($data);

            // الحقول المخصّصة (الـTrait HasCustomFields لازم يكون مستخدم في موديل CallLog)
            if (method_exists($log, 'syncCustomFields')) {
                $log->syncCustomFields($request->input('custom_fields', []));
            }

            $this->systemLog('call_log.created','call_logs',$log->id, [
                'after' => $log->toArray(),
                'cf'    => $request->input('custom_fields', []),
            ], $request);
        });

        Toastr::success('تم إضافة سجل مكالمة');
        return redirect()->route('admin.call-logs.index');
    }

    public function edit(CallLog $log)
    {
          $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("call_logs.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        // تحميل الحقول المخصّصة مع تعريفاتها
        $log->load(['lead','admin','outcome','customFieldValues.customField']);

        $cfDefs   = $this->customFieldDefs();
        $cfValues = $this->extractCustomValues($log);

        return view('admin-views.call_logs.edit', [
            'log'      => $log,
            'leads'    => Lead::orderByDesc('id')->limit(200)->get(),
            'outcomes' => CallOutcome::orderBy('sort_order')->get(),
            'admins'   => Admin::orderBy('email')->get(),
            'cfDefs'   => $cfDefs,
            'cfValues' => $cfValues,
        ]);
    }

    public function update(Request $request, CallLog $log)
    {
        $data = $this->validatePayload($request);
        $data['admin_id'] = $data['admin_id'] ?? auth('admin')->id();
        $this->normalizeTiming($data);

        $before = $log->replicate()->toArray();

        DB::transaction(function () use ($log, $before, $data, $request) {
            $log->update($data);

            // تحديث الحقول المخصّصة
            if (method_exists($log, 'syncCustomFields')) {
                $log->syncCustomFields($request->input('custom_fields', []));
            }

            $this->systemLog('call_log.updated','call_logs',$log->id, [
                'before'  => $before,
                'after'   => $log->toArray(),
                'changes' => $log->getChanges(),
                'cf'      => $request->input('custom_fields', []),
            ], $request);
        });

        Toastr::success('تم تحديث سجل المكالمة');
        return redirect()->route('admin.call-logs.index');
    }

    public function destroy(Request $request, CallLog $log)
    {
          $adminId = Auth::guard('admin')->id();
    $admin = DB::table('admins')->where('id', $adminId)->first();

    if (!$admin) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $roleId = $admin->role_id;
    $role = DB::table('roles')->where('id', $roleId)->first();

    if (!$role) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    $decodedData = json_decode($role->data, true);
    if (is_string($decodedData)) {
        $decodedData = json_decode($decodedData, true);
    }

    if (!is_array($decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }

    if (!in_array("call_logs.destroy", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        DB::transaction(function () use ($log, $request) {
            $snapshot = $log->toArray();
            $id = $log->id;
            $log->delete();
            $this->systemLog('call_log.deleted','call_logs',$id,['before'=>$snapshot],$request);
        });

        Toastr::success('تم حذف سجل المكالمة');
        return back();
    }

    public function export(Request $request)
    {
        $q = CallLog::query()->with([
            'lead','admin','outcome',
            'customFieldValues.customField'
        ]);
        $this->applyFilters($request, $q);

        // نجلب التعريفات المفعّلة مرّة واحدة (CallLog)
        $cfDefs = $this->customFieldDefs();

        $rows = $q->orderByDesc('started_at')->orderByDesc('id')->get()->map(function (CallLog $l) use ($cfDefs) {
            $dur = $l->duration_sec;

            $row = [
                'ID'                 => $l->id,
                'Lead'               => optional($l->lead)->contact_name ?: optional($l->lead)->company_name,
                'Lead Phone'         => trim((optional($l->lead)?->country_code).' '.(optional($l->lead)?->phone)),
                'Admin Email'        => optional($l->admin)->email,
                'Outcome'            => optional($l->outcome)->name,
                'Direction'          => $l->direction,
                'Channel'            => $l->channel,
                'Phone Used'         => $l->phone_used,
                'Started At'         => optional($l->started_at)?->toDateTimeString(),
                'Ended At'           => optional($l->ended_at)?->toDateTimeString(),
                'Duration (sec)'     => $dur,
                'Duration (H:MM:SS)' => $this->formatSeconds($dur),
                'Next Action'        => optional($l->next_action_at)?->toDateTimeString(),
                'Recording URL'      => $l->recording_url,
                'Notes'              => $l->notes,
                'Created At'         => optional($l->created_at)?->toDateTimeString(),
            ];

            // استخدم الـaccessor من الـTrait (لو موجود)
            $cfMap = property_exists($l, 'attributes') && method_exists($l, 'getCustomFieldsArrayAttribute')
                ? ($l->custom_fields_array ?? [])
                : $this->extractCustomValues($l);

            foreach ($cfDefs as $def) {
                $key = $def->key;
                $val = $cfMap[$key] ?? null;

                if (is_array($val)) {
                    $row['CF: '.$def->name] = implode(', ', array_map(
                        fn($x) => is_scalar($x) ? (string)$x : json_encode($x, JSON_UNESCAPED_UNICODE),
                        $val
                    ));
                } elseif (is_object($val)) {
                    $row['CF: '.$def->name] = json_encode($val, JSON_UNESCAPED_UNICODE);
                } else {
                    $row['CF: '.$def->name] = $val;
                }
            }

            return $row;
        });

        return (new FastExcel($rows))->download('call_logs.xlsx');
    }

    /* -------------------- Helpers -------------------- */

    private function applyFilters(Request $request, Builder $q): void
    {
        if ($s = $request->string('search')->toString()) {
            $q->where(function(Builder $w) use ($s) {
                $w->whereHas('lead', function($qq) use ($s) {
                    $qq->where('company_name','like',"%{$s}%")
                       ->orWhere('contact_name','like',"%{$s}%")
                       ->orWhere('email','like',"%{$s}%")
                       ->orWhere('phone','like',"%{$s}%");
                })
                ->orWhereHas('admin', function($qq) use ($s) {
                    $qq->where('email','like',"%{$s}%");
                });
            });
        }

        if ($request->filled('outcome_id')) $q->where('outcome_id',(int)$request->outcome_id);
        if ($request->filled('admin_id'))   $q->where('admin_id',(int)$request->admin_id);

        if ($request->filled('started_from')) {
            $from = $request->date('started_from')->startOfDay();
            $q->where('started_at','>=',$from);
        }
        if ($request->filled('started_to')) {
            $to = $request->date('started_to')->endOfDay();
            $q->where('started_at','<=',$to);
        }

        if ($request->filled('ended_from')) {
            $from = $request->date('ended_from')->startOfDay();
            $q->where('ended_at','>=',$from);
        }
        if ($request->filled('ended_to')) {
            $to = $request->date('ended_to')->endOfDay();
            $q->where('ended_at','<=',$to);
        }

        if ($request->filled('direction')) {
            $q->whereIn('direction', (array)$request->input('direction'));
        }
        if ($request->filled('channel')) {
            $q->whereIn('channel', (array)$request->input('channel'));
        }
    }

    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'lead_id'        => ['required','exists:leads,id'],
            'admin_id'       => ['nullable','exists:admins,id'],
            'outcome_id'     => ['nullable','exists:call_outcomes,id'],
            'direction'      => ['nullable','in:in,out,missed'],
            'channel'        => ['nullable','in:phone,whatsapp,sms'],
            'phone_used'     => ['nullable','string','max:50'],
            'recording_url'  => ['nullable','url','max:2048'],
            'notes'          => ['nullable','string'],

            'started_at'     => ['nullable','date'],
            'ended_at'       => ['nullable','date','after_or_equal:started_at'],
            'duration_sec'   => ['nullable','integer','min:0'],
            'next_action_at' => ['nullable','date'],

            // مصفوفة الحقول المخصّصة جاية من الفورم باسم custom_fields[key] = value
            'custom_fields'  => ['sometimes','array'],
        ]);
    }

    /** يضمن اتساق التوقيت */
    private function normalizeTiming(array &$data): void
    {
        $started = !empty($data['started_at']) ? Carbon::parse($data['started_at']) : null;
        $ended   = !empty($data['ended_at'])   ? Carbon::parse($data['ended_at'])   : null;
        $dur     = isset($data['duration_sec']) ? (int)$data['duration_sec'] : null;

        if ($started && $ended) {
            $data['duration_sec'] = max(0, $ended->diffInSeconds($started));
            $data['started_at']   = $started;
            $data['ended_at']     = $ended;
            return;
        }

        if ($started && is_int($dur)) {
            $data['ended_at']     = (clone $started)->addSeconds($dur);
            $data['duration_sec'] = $dur;
            $data['started_at']   = $started;
            return;
        }

        if ($ended && is_int($dur)) {
            $data['started_at']   = (clone $ended)->subSeconds($dur);
            $data['duration_sec'] = $dur;
            $data['ended_at']     = $ended;
            return;
        }
    }

    private function formatSeconds($s): string
    {
        if (!is_numeric($s) || $s < 0) return '—';
        $s = (int)$s;
        $h = intdiv($s, 3600);
        $m = intdiv($s % 3600, 60);
        $ss = $s % 60;
        return ($h ? $h.':' : '') . str_pad($m,2,'0',STR_PAD_LEFT) . ':' . str_pad($ss,2,'0',STR_PAD_LEFT);
    }

    private function systemLog(string $action, ?string $table, ?int $recordId, array $meta, Request $request): void
    {
        SystemLog::create([
            'actor_admin_id' => auth('admin')->id(),
            'action'         => $action,
            'table_name'     => $table,
            'record_id'      => $recordId,
            'lead_id'        => null,
            'ip_address'     => $request->ip(),
            'user_agent'     => substr((string)$request->userAgent(), 0, 255),
            'meta'           => $meta,
            'created_at'     => now()->setTimezone('UTC'),
        ]);
    }

    /* ===== Custom Fields helpers ===== */

    /** تعريفات الحقول المفعّلة الخاصة بموديل CallLog */
    private function customFieldDefs()
    {
        return CustomField::query()
            ->where('applies_to', CallLog::class)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * يعيد مصفوفة key => value للقيم المرفقة بالموديل (fallback لو الaccessor مش متاح).
     */
    private function extractCustomValues(CallLog $log): array
    {
        // لو الـTrait مفعّل، استخدمه مباشرة
        if (method_exists($log, 'getCustomFieldsArrayAttribute')) {
            return $log->custom_fields_array ?? [];
        }

        // fallback: من العلاقة
        $map = [];
        $values = $log->relationLoaded('customFieldValues')
            ? $log->customFieldValues
            : $log->customFieldValues()->with('customField')->get();

        foreach ($values as $cv) {
            $key = optional($cv->customField)->key;
            if (!$key) continue;
            $map[$key] = $cv->value_json ?? $cv->value;
        }
        return $map;
    }
}
