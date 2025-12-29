<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Status;
use App\Models\Admin;
use App\Models\Project;
use App\Models\TaskAssignee;
use App\Models\SystemLog;                 // <<— اضافه
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Events\TaskAssigned;
use App\Events\ApprovalRequested;
use App\Events\ApprovalDecided;

class TaskController extends Controller
{
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
private function applyVisibility(Request $request, $query)
{
    $admin = Auth::guard('admin')->user();
    $role  = DB::table('roles')->where('id', $admin->role_id)->first();
    $perms = $role ? json_decode($role->data, true) : [];
    if (is_string($perms)) $perms = json_decode($perms, true);
    $perms = is_array($perms) ? $perms : [];

    // يشوف الكل
    if (in_array('scope.view.all', $perms)) {
        return $query;
    }

    // فرع
    if (in_array('scope.view.branch', $perms) && isset($admin->branch_id)) {
        $query->where(function ($q) use ($admin) {
            $q->where('owner_id', $admin->id)
              ->orWhere('created_by_admin_id', $admin->id)
              ->orWhereHas('owner', fn($qq) => $qq->where('branch_id', $admin->branch_id));
        });
        return $query;
    }

    // قسم
    if (in_array('scope.view.department', $perms) && isset($admin->department_id)) {
        $query->where(function ($q) use ($admin) {
            $q->where('owner_id', $admin->id)
              ->orWhere('created_by_admin_id', $admin->id)
              ->orWhereHas('owner', fn($qq) => $qq->where('department_id', $admin->department_id));
        });
        return $query;
    }

    // شجرة المديرين
    if (in_array('scope.view.manager_tree', $perms)) {
        $ids = $this->subordinateIds($admin->id);
        $query->where(function ($q) use ($admin, $ids) {
            $q->where('owner_id', $admin->id)
              ->orWhere('created_by_admin_id', $admin->id)
              ->orWhereIn('owner_id', $ids);
        });
        return $query;
    }

    // self
    if (in_array('scope.view.self', $perms)) {
        $query->where(function ($q) use ($admin) {
            $q->where('owner_id', $admin->id)
              ->orWhere('created_by_admin_id', $admin->id);
        });
    }

    return $query;
}

private function guardViewRecord(Lead $lead): void
{
    $admin = Auth::guard('admin')->user();
    $role  = DB::table('roles')->where('id', $admin->role_id)->first();
    $perms = $role ? json_decode($role->data, true) : [];
    if (is_string($perms)) $perms = json_decode($perms, true);
    $perms = is_array($perms) ? $perms : [];

    if (in_array('scope.view.all', $perms)) {
        return;
    }

    $allowed = false;

    // self
    if (in_array('scope.view.self', $perms)) {
        $allowed = $allowed || ($lead->owner_id == $admin->id) || ($lead->created_by_admin_id == $admin->id);
    }

    // branch
    if (in_array('scope.view.branch', $perms) && isset($admin->branch_id) && $lead->relationLoaded('owner') || true) {
        $lead->loadMissing('owner');
        $allowed = $allowed || ($lead->owner && $lead->owner->branch_id == $admin->branch_id);
    }

    // department
    if (in_array('scope.view.department', $perms) && isset($admin->department_id)) {
        $lead->loadMissing('owner');
        $allowed = $allowed || ($lead->owner && $lead->owner->department_id == $admin->department_id);
    }

    // manager tree
    if (in_array('scope.view.manager_tree', $perms)) {
        $ids = $this->subordinateIds($admin->id);
        $allowed = $allowed || in_array($lead->owner_id, $ids) || ($lead->owner_id == $admin->id);
    }

    if (!$allowed) {
        Toastr::warning('غير مسموح لك بعرض هذا السجل.');
        abort(403);
    }
}
}

    private function subordinateIds(int $managerId): array
    {
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
        if ($resp = $this->ensurePermissionOrBack($request, 'task.index')) return $resp;

        $q         = $request->query('q');
        $statusId  = $request->query('status_id');
        $priority  = $request->query('priority');
        $assignee  = $request->query('assignee_id');
        $projectId = $request->query('project_id');
        $active    = $request->query('active');

        $tasks = Task::query()
            ->with(['project:id,name','status:id,name','creator:id,f_name,l_name'])
            ->when($q, fn($qq) =>
                $qq->where(function ($w) use ($q) {
                    $w->where('title','like',"%{$q}%")->orWhere('description','like',"%{$q}%");
                }))
            ->when($statusId, fn($qq) => $qq->where('status_id', $statusId))
            ->when($priority, fn($qq) => $qq->where('priority', $priority))
            ->when($projectId, fn($qq) => $qq->where('project_id', $projectId))
            ->when($assignee, fn($qq) =>
                $qq->whereHas('assignees', fn($s) => $s->where('admin_id', $assignee)))
            ->when($active !== null && $active !== '', fn($qq) => $qq->where('active', (bool)$active));

        $this->applyVisibility($request, $tasks);

        $tasks = $tasks->orderByDesc('id')->paginate(20)->withQueryString();

        // Log list
        $this->log('list', 'tasks', null, [
            'filters' => compact('q','statusId','priority','assignee','projectId','active')
        ], $request);

        return view('admin-views.tasks.index', [
            'tasks'     => $tasks,
            'statuses'  => Status::select('id','name')->get(),
            'projects'  => Project::select('id','name')->get(),
            'assignees' => Admin::select('id','f_name','l_name')->get(),
            'filters'   => compact('q','statusId','priority','assignee','projectId','active'),
        ]);
    }

    public function create(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.store')) return $resp;

        return view('admin-views.tasks.create', [
            'projects'  => Project::select('id','name')->get(),
            'statuses'  => Status::select('id','name')->get(),
            'assignees' => Admin::select('id','f_name','l_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.store')) return $resp;

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
            'active'            => ['nullable','boolean'], // لو عندك العمود
            'assignees'         => ['nullable','array'],
            'assignees.*'       => ['exists:admins,id'],
        ]);

        $task = new Task($data);
        $task->created_by = Auth::guard('admin')->id();
        $task->save();

        // Log create
        $this->log('create', 'tasks', $task->id, [
            'new'     => $task->toArray(),
            'lead_id' => $task->lead_id,
        ], $request);

        // إسناد
        if (!empty($data['assignees'])) {
            foreach ($data['assignees'] as $uid) {
                TaskAssignee::create([
                    'task_id'     => $task->id,
                    'admin_id'    => $uid,
                    'role'        => TaskAssignee::ROLE_ASSIGNEE,
                    'priority'    => $task->priority,
                    'due_at'      => $task->due_at,
                    'assigned_by' => Auth::guard('admin')->id(),
                ]);

                // Log assignment
                $this->log('assign', 'task_assignees', $task->id, [
                    'task_id'  => $task->id,
                    'assignee' => $uid,
                ], $request);

                // Event → Notification
                event(new TaskAssigned($task, Admin::find($uid), Auth::guard('admin')->user()));
            }
        }

        // لو محتاجة موافقة
        if (!empty($data['approval_required'])) {
            $approvers = $this->approvers();
            event(new ApprovalRequested('task', $task->id, $approvers, Auth::guard('admin')->id()));

            // Log approval requested
            $this->log('approval_requested', 'tasks', $task->id, [
                'approvers' => $approvers,
            ], $request);
        }

        Toastr::success('تم إنشاء المهمة بنجاح');
        return redirect()->route('admin.tasks.show', $task->id);
    }

    public function show(Request $request, Task $task)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.index')) return $resp;

        $this->applyVisibility($request, Task::whereKey($task->id));
        $task->load(['project','status','creator','assignees.admin']);

        // Log show
        $this->log('show', 'tasks', $task->id, [], $request);

        return view('admin-views.tasks.show', compact('task'));
    }

    public function edit(Request $request, Task $task)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.update')) return $resp;

        // Log edit open
        $this->log('edit', 'tasks', $task->id, [], $request);

        return view('admin-views.tasks.edit', [
            'task'      => $task->load(['assignees']),
            'projects'  => Project::select('id','name')->get(),
            'statuses'  => Status::select('id','name')->get(),
            'assignees' => Admin::select('id','f_name','l_name')->get(),
        ]);
    }

    public function update(Request $request, Task $task)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.update')) return $resp;

        $old = $task->toArray();

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
            'approval_status'   => ['nullable','in:pending,approved,rejected'],
            'approved_by'       => ['nullable','exists:admins,id'],
            'approved_at'       => ['nullable','date'],
            'rejection_reason'  => ['nullable','string','max:255'],
            'next_step_hint'    => ['nullable','string','max:255'],
            'active'            => ['nullable','boolean'], // لو عندك العمود
            'assignees'         => ['nullable','array'],
            'assignees.*'       => ['exists:admins,id'],
        ]);

        $task->update($data);

        // Log update diff
        $this->log('update', 'tasks', $task->id, [
            'before'  => $old,
            'after'   => $task->toArray(),
            'lead_id' => $task->lead_id,
        ], $request);

        // إعادة الإسناد لو جاي في الريكوست
        if ($request->has('assignees')) {
            TaskAssignee::where('task_id', $task->id)->delete();
            foreach ($data['assignees'] ?? [] as $uid) {
                TaskAssignee::create([
                    'task_id'     => $task->id,
                    'admin_id'    => $uid,
                    'role'        => TaskAssignee::ROLE_ASSIGNEE,
                    'priority'    => $task->priority,
                    'due_at'      => $task->due_at,
                    'assigned_by' => Auth::guard('admin')->id(),
                ]);

                // Log re-assign
                $this->log('assign', 'task_assignees', $task->id, [
                    'task_id'  => $task->id,
                    'assignee' => $uid,
                ], $request);

                event(new TaskAssigned($task, Admin::find($uid), Auth::guard('admin')->user()));
            }
        }

        // قرار الموافقة؟
        if (!empty($data['approval_status']) && $data['approval_status'] !== 'pending') {
            event(new ApprovalDecided(
                'task',
                $task->id,
                $data['approval_status'],
                $data['approved_by'] ?? Auth::guard('admin')->id(),
                $data['rejection_reason'] ?? null,
                $data['next_step_hint'] ?? null
            ));

            // Log approval decision
            $this->log('approval_decision', 'tasks', $task->id, [
                'status'  => $data['approval_status'],
                'by'      => $data['approved_by'] ?? Auth::guard('admin')->id(),
                'reason'  => $data['rejection_reason'] ?? null,
                'next'    => $data['next_step_hint'] ?? null,
            ], $request);
        }

        Toastr::success('تم تحديث المهمة بنجاح');
        return redirect()->route('admin.tasks.show', $task->id);
    }

    public function destroy(Request $request, Task $task)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.destroy')) return $resp;

        $snap = $task->toArray();
        $task->delete();

        // Log delete
        $this->log('delete', 'tasks', $task->id, [
            'deleted' => $snap,
            'lead_id' => $snap['lead_id'] ?? null,
        ], $request);

        Toastr::success('تم حذف المهمة');
        return redirect()->route('admin.tasks.index');
    }

    public function active(Request $request, Task $task)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.update')) return $resp;

        // يتطلب عمود active في tasks
        $from = $task->active ?? null;
        $task->active = !($task->active ?? false);
        $task->save();

        // Log
        $this->log('toggle_active', 'tasks', $task->id, [
            'from'    => (int)$from,
            'to'      => (int)$task->active,
            'lead_id' => $task->lead_id,
        ], $request);

        Toastr::success('تم تحديث حالة التفعيل');
        return back();
    }

    private function approvers(): array
    {
        // IDs لليدر/السوبر أدمن — عدلها حسب نظامك
        $ids = DB::table('admins')->whereIn('role_id', function ($q) {
            $q->from('roles')->select('id')->whereIn('name', ['leader','super_admin']);
        })->pluck('id')->all();

        if (empty($ids)) {
            $ids = DB::table('admins')->orderBy('id')->limit(1)->pluck('id')->all();
        }
        return $ids;
    }
    public function approve(Request $request, Task $task)
{
    if ($resp = $this->ensurePermissionOrBack($request, 'task.approve')) return $resp;

    $data = $request->validate([
        'decision' => 'nullable|in:approved,rejected',
        'reason'   => 'nullable|string|max:255',
    ]);

    $task->approval_status  = 'approved';
    $task->approved_by      = Auth::guard('admin')->id();
    $task->approved_at      = now();
    $task->save();

    Toastr::success('تم تحديث حالة المهمة بنجاح');
    return back();
}
public function reject(Request $request, Task $task)
{
    if ($resp = $this->ensurePermissionOrBack($request, 'task.approve')) return $resp;

    $data = $request->validate([
        'rejection_reason' => 'required|string|max:255',
        'next_step_hint'=>'required'
    ]);

    $task->approval_status  = 'rejected';
    $task->approved_by      = Auth::guard('admin')->id();
    $task->approved_at      = now();
    $task->rejection_reason = $data['rejection_reason'];
        $task->next_step_hint = $data['next_step_hint'];

    $task->save();

    Toastr::error('تم رفض المهمة مع ذكر السبب');
    return back();
}

}
