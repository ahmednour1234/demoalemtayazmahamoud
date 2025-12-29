<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{CallOutcome, SystemLog};
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;
class CallOutcomeController extends Controller
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

    if (!in_array("call_outcomes.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $q = CallOutcome::query();

        if ($s = $request->string('search')->toString()) {
            $q->where(fn($qq) => $qq->where('name','like',"%{$s}%")
                                     ->orWhere('code','like',"%{$s}%"));
        }
        if ($request->has('active') && $request->active !== '') {
            $q->where('is_active', (int)$request->boolean('active'));
        }

        $outcomes = $q->orderBy('sort_order')->orderBy('id')->paginate(20)->withQueryString();

        return view('admin-views.call_outcomes.index', [
            'outcomes' => $outcomes,
            'filters'  => $request->only(['search','active']),
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

    if (!in_array("call_outcomes.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }
        return view('admin-views.call_outcomes.create');
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

    if (!in_array("call_outcomes.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }
        $data = $request->validate([
            'name'       => ['required','string','max:190'],
            'code'       => ['required','string','max:100','unique:call_outcomes,code'],
            'sort_order' => ['nullable','integer'],
            'is_active'  => ['nullable','boolean'],
        ]);

        $data['is_active']  = (bool)($data['is_active'] ?? true);
        $data['sort_order'] = $data['sort_order'] ?? 100;

        DB::transaction(function () use ($data, $request) {
            $outcome = CallOutcome::create($data);
            $this->log('call_outcome.created','call_outcomes',$outcome->id,['after'=>$outcome->toArray()],$request);
        });

        Toastr::success('تم إنشاء نتيجة المكالمة بنجاح');
        return redirect()->route('admin.call-outcomes.index');
    }

    public function edit(CallOutcome $outcome)
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

    if (!in_array("call_outcomes.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }
        return view('admin-views.call_outcomes.edit', compact('outcome'));
    }

    public function update(Request $request, CallOutcome $outcome)
    {
        $data = $request->validate([
            'name'       => ['required','string','max:190'],
            'code'       => ['required','string','max:100','unique:call_outcomes,code,'.$outcome->id],
            'sort_order' => ['nullable','integer'],
            'is_active'  => ['nullable','boolean'],
        ]);

        $before = $outcome->replicate()->toArray();
        $data['is_active']  = (bool)($data['is_active'] ?? $outcome->is_active);
        $data['sort_order'] = $data['sort_order'] ?? ($outcome->sort_order ?? 100);

        DB::transaction(function () use ($outcome, $before, $data, $request) {
            $outcome->update($data);
            $this->log('call_outcome.updated','call_outcomes',$outcome->id,[
                'before'=>$before,'after'=>$outcome->toArray(),'changes'=>$outcome->getChanges()
            ],$request);
        });

        Toastr::success('تم تحديث نتيجة المكالمة');
        return redirect()->route('admin.call-outcomes.index');
    }

    public function destroy(Request $request, CallOutcome $outcome)
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

    if (!in_array("call_outcomes.destroy", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }
        DB::transaction(function () use ($outcome, $request) {
            $snapshot = $outcome->toArray();
            $id = $outcome->id;
            $outcome->delete();
            $this->log('call_outcome.deleted','call_outcomes',$id,['before'=>$snapshot],$request);
        });

        Toastr::success('تم حذف نتيجة المكالمة');
        return redirect()->route('admin.call-outcomes.index');
    }

    public function active(Request $request, CallOutcome $outcome)
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

    if (!in_array("call_outcomes.active", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }
        $request->validate(['active' => ['required','boolean']]);
        $before = $outcome->replicate()->toArray();

        $outcome->is_active = (bool)$request->boolean('active');
        $outcome->save();

        $this->log('call_outcome.active_toggled','call_outcomes',$outcome->id,[
            'before'=>$before,'after'=>$outcome->toArray(),'active'=>$outcome->is_active
        ],$request);

        Toastr::success('تم تحديث حالة التفعيل');
        return back();
    }

    public function export(Request $request)
    {
        $q = CallOutcome::query();
        if ($s = $request->string('search')->toString()) {
            $q->where(fn($qq)=>$qq->where('name','like',"%{$s}%")->orWhere('code','like',"%{$s}%"));
        }
        if ($request->has('active') && $request->active !== '') {
            $q->where('is_active',(int)$request->boolean('active'));
        }
        $rows = $q->orderBy('sort_order')->get()->map(function(CallOutcome $o){
            return [
                'ID'         => $o->id,
                'Name'       => $o->name,
                'Code'       => $o->code,
                'Sort Order' => $o->sort_order,
                'Active'     => $o->is_active ? 'Yes' : 'No',
                'Created At' => optional($o->created_at)->toDateTimeString(),
            ];
        });

        return (new FastExcel($rows))->download('call_outcomes.xlsx');
    }

    private function log(string $action, ?string $table, ?int $recordId, array $meta, Request $request): void
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
}
