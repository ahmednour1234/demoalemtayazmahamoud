<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class ProjectMemberController extends Controller
{
    /* ===== صلاحيات ===== */
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
        if (!is_array($decoded) || !in_array($permissionKey, $decoded, true)) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return redirect()->back();
        }
        return null;
    }

    /* (اختياري) فلترة رؤية المشروع — نفس منطقك المستخدم في ProjectController */
    private function canSeeProject(Project $project): bool
    {
        $me = Auth::guard('admin')->user();
        if (!$me) return false;

        $raw = DB::table('roles')->where('id', $me->role_id)->value('data');
        $perms = is_string($raw) ? json_decode($raw, true) : $raw;
        if (is_string($perms)) $perms = json_decode($perms, true);
        $perms = is_array($perms) ? $perms : [];

        if (in_array('scope.view.all', $perms, true)) return true;

        // تقدر تستبدل المنطق ده بمنظومة الرؤية عندك
        if (in_array('scope.view.self', $perms, true)) {
            $isOwner = ($project->owner_id === $me->id);
            $isMember = ProjectMember::where('project_id', $project->id)->where('admin_id', $me->id)->exists();
            if ($isOwner || $isMember) return true;
        }

        // زوّد هنا branch/department/manager_tree/team لو محتاج
        return in_array('scope.view.branch', $perms, true)
            || in_array('scope.view.department', $perms, true)
            || in_array('scope.view.manager_tree', $perms, true)
            || in_array('scope.view.team', $perms, true);
    }

    /* ================== Actions ================== */

    /** عرض أعضاء مشروع محدّد */
    public function index(Request $request, Project $project)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.index')) return $resp;
        if (!$this->canSeeProject($project)) {
            Toastr::warning('غير مسموح برؤية هذا المشروع.');
            return redirect()->route('admin.projects.index');
        }

        $members = ProjectMember::with('admin:id,f_name,l_name,email')
            ->where('project_id', $project->id)
            ->orderByRaw("FIELD(role, 'owner','leader','member','viewer') ASC")
            ->orderBy('id','asc')
            ->paginate(30);

        $admins = Admin::select('id','f_name','l_name','email')->orderBy('f_name')->get();

        return view('admin-views.projects.members.index', compact('project','members','admins'));
    }

    /** إضافة عضو جديد للمشروع */
    public function store(Request $request, Project $project)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.members.store')) return $resp;
        // if (!$this->canSeeProject($project)) {
        //     Toastr::warning('غير مسموح بالتعديل على هذا المشروع.');
        //     return redirect()->route('admin.projects.index');
        // }

        $data = $request->validate([
            'admin_id' => ['required','exists:admins,id'],
            'role'     => ['required','in:'.implode(',', [
                ProjectMember::ROLE_OWNER,
                ProjectMember::ROLE_LEADER,
                ProjectMember::ROLE_MEMBER,
                ProjectMember::ROLE_VIEWER,
            ])],
        ]);

        // منع التكرار
        $exists = ProjectMember::where('project_id',$project->id)
            ->where('admin_id',$data['admin_id'])->exists();
        if ($exists) {
            Toastr::warning('المستخدم موجود بالفعل في أعضاء المشروع.');
            return back();
        }

        ProjectMember::create([
            'project_id' => $project->id,
            'admin_id'   => $data['admin_id'],
            'role'       => $data['role'],
            'added_by'   => Auth::guard('admin')->id(),
        ]);

        Toastr::success('تم إضافة العضو للمشروع.');
        return back();
    }

    /** تحديث دور عضو */
    public function update(Request $request, Project $project, ProjectMember $member)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.update')) return $resp;
        if ($member->project_id !== $project->id) {
            Toastr::error('طلب غير صحيح.');
            return back();
        }
       
        $data = $request->validate([
            'role' => ['required','in:'.implode(',', [
                ProjectMember::ROLE_OWNER,
                ProjectMember::ROLE_LEADER,
                ProjectMember::ROLE_MEMBER,
                ProjectMember::ROLE_VIEWER,
            ])],
        ]);

        $member->update(['role' => $data['role']]);

        Toastr::success('تم تحديث دور العضو.');
        return back();
    }

    /** حذف عضو من المشروع */
    public function destroy(Request $request, Project $project, ProjectMember $member)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'project.members.destroy')) return $resp;

        if ($member->project_id !== $project->id) {
            Toastr::error('طلب غير صحيح.');
            return back();
        }
   

        // منع حذف الـ Owner الأخير
        if ($member->role === ProjectMember::ROLE_OWNER) {
            $ownersCount = ProjectMember::where('project_id', $project->id)
                ->where('role', ProjectMember::ROLE_OWNER)->count();
            if ($ownersCount <= 1) {
                Toastr::warning('لا يمكن حذف المالك الوحيد للمشروع.');
                return back();
            }
        }

        $member->delete();
        Toastr::success('تم حذف العضو من المشروع.');
        return back();
    }
}
