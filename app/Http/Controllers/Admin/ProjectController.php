<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Status;
use App\Models\Admin;
use App\Models\ProjectMember;
use App\Models\SystemLog;            // <<— اضافه
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class ProjectController extends Controller
{
    /* === صلاحياتك الجاهزة === */
    private function ensurePermissionOrBack(Request $request, string $permissionKey): ?RedirectResponse
    {
        $adminId = Auth::guard('admin')->id();
        $admin = DB::table('admins')->where('id', $adminId)->first();

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

    /* === فلترة مستوى الرؤية === */
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
            $query->where(function ($q) use ($admin) {
                $q->where('owner_id', $admin->id)
                  ->orWhereHas('owner', fn($qq) => $qq->where('branch_id', $admin->branch_id))
                  ->orWhereHas('members.admin', fn($qq) => $qq->where('branch_id', $admin->branch_id));
            });
            return $query;
        }

        // department
        if (in_array('scope.view.department', $perms) && isset($admin->department_id)) {
            $query->where(function ($q) use ($admin) {
                $q->where('owner_id', $admin->id)
                  ->orWhereHas('owner', fn($qq) => $qq->where('department_id', $admin->department_id))
                  ->orWhereHas('members.admin', fn($qq) => $qq->where('department_id', $admin->department_id));
            });
            return $query;
        }

        // manager tree (تقريبي — استبدله بدالتك الفعلية)
        if (in_array('scope.view.manager_tree', $perms)) {
            $ids = $this->subordinateIds($admin->id);
            $query->where(function ($q) use ($admin, $ids) {
                $q->where('owner_id', $admin->id)
                  ->orWhereIn('owner_id', $ids)
                  ->orWhereHas('members', fn($qq) => $qq->whereIn('admin_id', $ids));
            });
            return $query;
        }

        // team (لو عندك جداول تيمز)
        if (in_array('scope.view.team', $perms)) {
            $teamMemberAdminIds = DB::table('team_members')
                ->whereIn('team_id', function ($q) use ($admin) {
                    $q->from('team_members')->select('team_id')->where('admin_id', $admin->id);
                })->pluck('admin_id');

            $query->where(function ($q) use ($admin, $teamMemberAdminIds) {
                $q->where('owner_id', $admin->id)
                  ->orWhereIn('owner_id', $teamMemberAdminIds)
                  ->orWhereHas('members', fn($qq) => $qq->whereIn('admin_id', $teamMemberAdminIds));
            });
            return $query;
        }

        // self
        if (in_array('scope.view.self', $perms)) {
            $query->where(function ($q) use ($admin) {
                $q->where('owner_id', $admin->id)
                  ->orWhereHas('members', fn($qq) => $qq->where('admin_id', $admin->id));
            });
        }

        return $query;
    }

    private function subordinateIds(int $managerId): array
    {
        // TODO: استبدلها بمنطق شجرتك الحقيقي (recursive CTE أو path)
        return DB::table('admins')->where('manager_id', $managerId)->pluck('id')->all();
    }

    /* ============ System Log Helper ============ */
    private function log(string $action, ?string $table, ?int $recordId, array $meta, Request $request): void
    {
        SystemLog::create([
            'actor_admin_id' => auth('admin')->id(),
            'action'         => $action,
            'table_name'     => $table,
            'record_id'      => $recordId,
            'lead_id'        => $meta['lead_id'] ?? null,
            'ip_address'     => $request->ip(),
            'user_agent'     => substr((string)$request->userAgent(), 0, 255),
            'meta'           => $meta,
            'created_at'     => now()->setTimezone('UTC'),
        ]);
    }

    /* ===================== Actions ===================== */

    public function index(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.index')) return $resp;

        $q        = $request->query('q');
        $statusId = $request->query('status_id');
        $ownerId  = $request->query('owner_id');
        $active   = $request->query('active');

        $projects = Project::query()
            ->with(['owner:id,f_name,l_name', 'status:id,name'])
            ->when($q, fn($qq) =>
                $qq->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('code', 'like', "%{$q}%");
                }))
            ->when($statusId, fn($qq) => $qq->where('status_id', $statusId))
            ->when($ownerId, fn($qq) => $qq->where('owner_id', $ownerId))
            ->when($active !== null && $active !== '', fn($qq) => $qq->where('active', (bool)$active));

        $this->applyVisibility($request, $projects);

        $projects = $projects->orderByDesc('id')->paginate(20)->withQueryString();

        // Log view list (اختياري)
        $this->log('list', 'projects', null, [
            'filters' => compact('q','statusId','ownerId','active')
        ], $request);

        return view('admin-views.projects.index', [
            'projects'  => $projects,
            'statuses'  => Status::select('id','name')->get(),
            'owners'    => Admin::select('id','f_name','l_name')->get(),
            'filters'   => compact('q','statusId','ownerId','active'),
        ]);
    }

    public function create(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.store')) return $resp;

        return view('admin-views.projects.create', [
            'statuses' => Status::select('id','name')->get(),
            'owners'   => Admin::select('id','f_name','l_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.store')) return $resp;

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

        $project = Project::create($data);

        // Log
        $this->log('create', 'projects', $project->id, [
            'new'     => $project->toArray(),
            'lead_id' => $project->lead_id,
        ], $request);

        Toastr::success('تم إنشاء المشروع بنجاح');
        return redirect()->route('admin.projects.show', $project->id);
    }

    public function show(Request $request, Project $project)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.index')) return $resp;

        // check visibility
        $this->applyVisibility($request, Project::whereKey($project->id));
        $project->load(['owner','status','members.admin','tasks']);

        // Log
        $this->log('show', 'projects', $project->id, [], $request);

        return view('admin-views.projects.show', compact('project'));
    }

    public function edit(Request $request, Project $project)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.update')) return $resp;

        $project->load('owner','status');

        // Log
        $this->log('edit', 'projects', $project->id, [], $request);

        return view('admin-views.projects.edit', [
            'project'  => $project,
            'statuses' => Status::select('id','name')->get(),
            'owners'   => Admin::select('id','f_name','l_name')->get(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.update')) return $resp;

        $old = $project->toArray();

        $data = $request->validate([
            'name'       => ['required','string','max:191'],
            'code'       => ['required','string','max:64',"unique:projects,code,{$project->id}"],
            'description'=> ['nullable','string'],
            'status_id'  => ['nullable','exists:statuses,id'],
            'owner_id'   => ['required','exists:admins,id'],
            'lead_id'    => ['nullable','exists:leads,id'],
            'priority'   => ['required','in:low,medium,high,urgent'],
            'start_date' => ['nullable','date'],
            'due_date'   => ['nullable','date','after_or_equal:start_date'],
            'active'     => ['nullable','boolean'],
        ]);

        $project->update($data);

        // Log diff
        $this->log('update', 'projects', $project->id, [
            'before'  => $old,
            'after'   => $project->toArray(),
            'lead_id' => $project->lead_id,
        ], $request);

        Toastr::success('تم تحديث المشروع بنجاح');
        return redirect()->route('admin.projects.show', $project->id);
    }

    public function destroy(Request $request, Project $project)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.destroy')) return $resp;

        $snap = $project->toArray();
        $project->delete();

        // Log
        $this->log('delete', 'projects', $project->id, [
            'deleted' => $snap,
            'lead_id' => $snap['lead_id'] ?? null,
        ], $request);

        Toastr::success('تم حذف المشروع');
        return redirect()->route('admin.projects.index');
    }

    public function active(Request $request, Project $project)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.update')) return $resp;

        $from = $project->active;
        $project->active = !$project->active;
        $project->save();

        // Log
        $this->log('toggle_active', 'projects', $project->id, [
            'from'    => (int)$from,
            'to'      => (int)$project->active,
            'lead_id' => $project->lead_id,
        ], $request);

        Toastr::success('تم تحديث حالة التفعيل');
        return back();
    }
}
