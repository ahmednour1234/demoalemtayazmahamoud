<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskAssignee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class TaskAssigneeController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $data = $request->validate([
            'admin_id' => ['required', 'exists:admins,id'],
            'role'     => ['required', 'in:assignee,reviewer,watcher'],
            'priority' => ['nullable', 'in:low,medium,high,urgent'],
            'due_at'   => ['nullable', 'date'],
        ]);

        $data['assigned_by'] = Auth::guard('admin')->id();

        TaskAssignee::create([
            'task_id'     => $task->id,
            'admin_id'    => $data['admin_id'],
            'role'        => $data['role'],
            'priority'    => $data['priority'] ?? 'medium',
            'due_at'      => $data['due_at'] ?? null,
            'assigned_by' => $data['assigned_by'],
        ]);

        Toastr::success('تم إسناد المهمة بنجاح');
        return back();
    }

    public function destroy(Task $task, TaskAssignee $assignee)
    {
        if ($assignee->task_id !== $task->id) {
            Toastr::warning('هذا الإسناد لا يخص هذه المهمة');
            return back();
        }

        $assignee->delete();
        Toastr::success('تمت إزالة الإسناد بنجاح');
        return back();
    }
}
