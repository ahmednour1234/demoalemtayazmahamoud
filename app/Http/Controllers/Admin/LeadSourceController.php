<?php
// app/Http/Controllers/Admin/LeadSourceController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeadSource\StoreLeadSourceRequest;
use App\Http\Requests\Admin\LeadSource\UpdateLeadSourceRequest;
use App\Models\LeadSource;
use App\Models\SystemLog;
use Brian2694\Toastr\Facades\Toastr; // ← مهم
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\CPU\translate;
use Illuminate\Support\Facades\Auth;

class LeadSourceController extends Controller
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

    if (!in_array("source.index", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $q = LeadSource::query();

        if ($s = $request->string('search')->toString()) {
            $q->where(fn($qq) => $qq->where('name','like',"%{$s}%")
                                    ->orWhere('code','like',"%{$s}%"));
        }

        // لو عندك عمود sort_order استخدمه، وإلا رتب بالاسم
        $sources = $q->when(schema()->hasColumn('lead_sources','sort_order'),
                        fn($qq) => $qq->orderBy('sort_order')->orderBy('id'),
                        fn($qq) => $qq->orderBy('name'))
                     ->paginate(20)->withQueryString();

        return view('admin-views.lead_sources.index', [
            'sources' => $sources,
            'filters' => $request->only(['search']),
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

    if (!in_array("source.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        return view('admin-views.lead_sources.create');
    }

    public function store(StoreLeadSourceRequest $request)
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

    if (!in_array("source.store", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        $data = $request->validated();
        // دعم اختياري للأعمدة الإضافية
        if (schema()->hasColumn('lead_sources','is_active')) {
            $data['is_active'] = (bool)($data['is_active'] ?? true);
        }
        if (schema()->hasColumn('lead_sources','sort_order')) {
            $data['sort_order'] = $data['sort_order'] ?? 100;
        }

        return DB::transaction(function () use ($data, $request) {
            $source = LeadSource::create($data);

            $this->log('lead_source.created', 'lead_sources', $source->id, [
                'after' => $source->toArray(),
            ], $request);

            Toastr::success('تم إنشاء المصدر بنجاح');
            return redirect()->route('admin.lead-sources.index');
        });
    }

    public function edit(LeadSource $source)
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

    if (!in_array("source.update", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        return view('admin-views.lead_sources.edit', compact('source'));
    }

    public function update(UpdateLeadSourceRequest $request, LeadSource $source)
    {
        $before = $source->replicate()->toArray();
        $data   = $request->validated();

        if (schema()->hasColumn('lead_sources','is_active')) {
            $data['is_active'] = (bool)($data['is_active'] ?? $source->is_active ?? true);
        }
        if (schema()->hasColumn('lead_sources','sort_order')) {
            $data['sort_order'] = $data['sort_order'] ?? $source->sort_order ?? 100;
        }

        return DB::transaction(function () use ($source, $before, $data, $request) {
            $source->update($data);

            $this->log('lead_source.updated', 'lead_sources', $source->id, [
                'before'  => $before,
                'after'   => $source->toArray(),
                'changes' => $source->getChanges(),
            ], $request);

            Toastr::success('تم تحديث المصدر بنجاح');
            return redirect()->route('admin.lead-sources.index');
        });
    }

    public function destroy(Request $request, LeadSource $source)
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

    if (!in_array("source.destroy", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        return DB::transaction(function () use ($source, $request) {
            $snapshot = $source->toArray();
            $id = $source->id;
            $source->delete();

            $this->log('lead_source.deleted', 'lead_sources', $id, [
                'before' => $snapshot,
            ], $request);

            Toastr::success('تم حذف المصدر بنجاح');
            return redirect()->route('admin.lead-sources.index');
        });
    }

    public function active(Request $request, LeadSource $source)
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

    if (!in_array("source.active", $decodedData)) {
        Toastr::warning('غير مسموح لك! كلم المدير.');
        return redirect()->back();
    }   
        if (!schema()->hasColumn('lead_sources','is_active')) {
            Toastr::error('عمود is_active غير موجود في lead_sources.');
            return back();
        }

        $request->validate(['active' => ['required','boolean']]);

        $before = $source->replicate()->toArray();
        $source->is_active = (bool) $request->boolean('active');
        $source->save();

        $this->log('lead_source.active_toggled', 'lead_sources', $source->id, [
            'before' => $before,
            'after'  => $source->toArray(),
            'active' => $source->is_active,
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
            'lead_id'        => null,
            'ip_address'     => $request->ip(),
            'user_agent'     => substr((string)$request->userAgent(), 0, 255),
            'meta'           => $meta,
            'created_at'     => now()->setTimezone('UTC'),
        ]);
    }
}

/**
 * Helper صغير عشان نتحقق من الأعمدة بأمان.
 */
if (!function_exists('schema')) {
    function schema() { return app('db')->connection()->getSchemaBuilder(); }
}
