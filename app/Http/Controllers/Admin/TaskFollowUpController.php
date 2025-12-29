<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class TaskFollowUpController extends Controller
{
    private function ensurePermissionOrBack(Request $request, string $permissionKey)
    {
        $adminId = Auth::guard('admin')->id();
        $admin = DB::table('admins')->where('id',$adminId)->first();
        if (!$admin) { Toastr::warning('غير مسموح لك! كلم المدير.'); return back(); }

        $role = DB::table('roles')->where('id', $admin->role_id)->first();
        $perms = $role ? json_decode($role->data, true) : [];
        if (is_string($perms)) $perms = json_decode($perms, true);
        if (!is_array($perms) || !in_array($permissionKey, $perms)) {
            Toastr::warning('غير مسموح لك! كلم المدير.');
            return back();
        }
        return null;
    }

    public function store(Request $request, Task $task)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.followups.store')) return $resp;

        $data = $request->validate([
            'next_follow_up_at' => ['required','date'],
            'comment'           => ['nullable','string'],
        ]);

        $fu = FollowUp::create([
            'task_id'           => $task->id,
            'created_by'        => Auth::guard('admin')->id(),
            'assigned_to'       => null,
            'next_follow_up_at' => $data['next_follow_up_at'],
            'status'            => 'scheduled',
            'comment'           => $data['comment'] ?? null,
        ]);

        // تنبيه لقائد الفريق/سوبر أدمن (لو عندك منطق محدّد) — placeholder:
        // NotificationService::push($leaderId, 'followup.created', 'متابعة جديدة', '...', ['follow_up_id'=>$fu->id]);

        if (method_exists($this,'log')) {
            $this->log('followup.store','follow_ups',$fu->id,['task_id'=>$task->id],$request);
        }

        Toastr::success('تم إضافة متابعة');
        return back();
    }

    public function done(Request $request, Task $task, FollowUp $followup)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.followups.done')) return $resp;

        if ($followup->task_id != $task->id) { Toastr::error('متابعة غير مطابقة.'); return back(); }

        $followup->status = 'done';
        $followup->save();

        if (method_exists($this,'log')) {
            $this->log('followup.done','follow_ups',$followup->id,['task_id'=>$task->id],$request);
        }

        Toastr::success('تم تسجيل المتابعة كمُنتهية');
        return back();
    }

    public function destroy(Request $request, Task $task, FollowUp $followup)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.followups.destroy')) return $resp;

        if ($followup->task_id != $task->id) { Toastr::error('متابعة غير مطابقة.'); return back(); }

        $followup->delete();

        if (method_exists($this,'log')) {
            $this->log('followup.destroy','follow_ups',$followup->id,['task_id'=>$task->id],$request);
        }

        Toastr::success('تم حذف المتابعة');
        return back();
    }
}
