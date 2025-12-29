<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeadStatus\StoreLeadStatusRequest;
use App\Http\Requests\Admin\LeadStatus\UpdateLeadStatusRequest;
use App\Models\LeadStatus;
use App\Models\SystemLog;
use Brian2694\Toastr\Facades\Toastr; // ← مهم
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;

class LeadStatusController extends Controller
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

    if (!in_array("status.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $q = LeadStatus::query();

        // فلاتر بسيطة
        if ($s = $request->string('search')->toString()) {
            $q->where(function ($qq) use ($s) {
                $qq->where('name', 'like', "%{$s}%")
                   ->orWhere('code', 'like', "%{$s}%");
            });
        }

        if (!is_null($request->get('active'))) {
            $q->where('is_active', (int) $request->boolean('active'));
        }

        $statuses = $q->orderBy('sort_order')
                      ->orderBy('id')
                      ->paginate(20)
                      ->withQueryString();

        return view('admin-views.lead_statuses.index', [
            'statuses' => $statuses,
            'filters'  => $request->only(['search', 'active']),
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

    if (!in_array("status.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        return view('admin-views.lead_statuses.create');
    }

    public function store(StoreLeadStatusRequest $request)
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

    if (!in_array("status.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $data = $request->validated();
        $data['is_active'] = (bool)($data['is_active'] ?? true);

        return DB::transaction(function () use ($data, $request) {
            $status = LeadStatus::create($data);

            $this->log('lead_status.created', 'lead_statuses', $status->id, [
                'after' => $status->toArray(),
            ], $request);

            Toastr::success('تم إنشاء الحالة بنجاح');
            return redirect()->route('admin.lead-statuses.index');
        });
    }

    public function edit(LeadStatus $status)
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

    if (!in_array("status.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        return view('admin-views.lead_statuses.edit', compact('status'));
    }

    public function update(UpdateLeadStatusRequest $request, LeadStatus $status)
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

    if (!in_array("status.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $before = $status->replicate()->toArray();
        $data   = $request->validated();

        return DB::transaction(function () use ($status, $before, $data, $request) {
            $status->update($data);

            $this->log('lead_status.updated', 'lead_statuses', $status->id, [
                'before'  => $before,
                'after'   => $status->toArray(),
                'changes' => $status->getChanges(),
            ], $request);

            Toastr::success('تم تحديث الحالة بنجاح');
            return redirect()->route('admin.lead-statuses.index');
        });
    }

    public function destroy(Request $request, LeadStatus $status)
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

    if (!in_array("status.destroy", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        return DB::transaction(function () use ($status, $request) {
            $snapshot = $status->toArray();
            $id       = $status->id;

            $status->delete();

            $this->log('lead_status.deleted', 'lead_statuses', $id, [
                'before' => $snapshot,
            ], $request);

            Toastr::success('تم حذف الحالة بنجاح');
            return redirect()->route('admin.lead-statuses.index');
        });
    }

    /**
     * تفعيل/تعطيل الحالة
     * PATCH /dashboard/lead-statuses/{status}/active?active=1|0
     */
    public function active(Request $request, LeadStatus $status)
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

    if (!in_array("status.active", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $request->validate(['active' => ['required', 'boolean']]);

        $before = $status->replicate()->toArray();

        $status->is_active = (bool) $request->boolean('active');
        $status->save();

        $this->log('lead_status.active_toggled', 'lead_statuses', $status->id, [
            'before' => $before,
            'after'  => $status->toArray(),
            'active' => $status->is_active,
        ], $request);

        Toastr::success('تم تحديث حالة التفعيل');
        return back();
    }

    private function log(string $action, ?string $table, ?int $recordId, array $meta, Request $request): void
    {
        SystemLog::create([
            'actor_admin_id' => auth('admin')->id(),
            'action'         => $action,
            'table_name'     => $table,
            'record_id'      => $recordId,
            'lead_id'        => null, // ليست مرتبطة بليد مباشرة
            'ip_address'     => $request->ip(),
            'user_agent'     => substr((string) $request->userAgent(), 0, 255),
            'meta'           => $meta,
            'created_at'     => now()->setTimezone('UTC'),
        ]);
    }
}
