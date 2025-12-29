<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class TaskCommentController extends Controller
{
    private function ensurePermissionOrBack(Request $request, string $permissionKey): ?RedirectResponse
    {
        $adminId = Auth::guard('admin')->id();
        $admin = DB::table('admins')->where('id', $adminId)->first();
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
        if ($resp = $this->ensurePermissionOrBack($request, 'task.comments.store')) return $resp;

        $data = $request->validate([
            'body' => ['required','string'],
        ]);

        $comment = Comment::create([
            'entity_type' => 'task',
            'entity_id'   => $task->id,
            'admin_id'    => Auth::guard('admin')->id(),
            'body'        => $data['body'],
        ]);

        // إشعارات بسيطة للمُنشيء والمسنّد إليهم
        $task->loadMissing(['assignees','creator']);
        $targets = [];
        if ($task->creator) $targets[] = $task->creator->id;
        foreach ($task->assignees as $a) $targets[] = $a->admin_id;
        $targets = array_unique(array_filter($targets));

        $title = 'تعليق جديد على مهمة';
        $body  = mb_substr($comment->body, 0, 120);
        $payload = ['entity_type'=>'task','entity_id'=>$task->id,'comment_id'=>$comment->id];

        foreach ($targets as $uid) {
            if ($uid != Auth::guard('admin')->id()) {
                \App\Services\NotificationService::push($uid, 'comment.task', $title, $body, $payload);
            }
        }

        // سجل نظام
        if (method_exists($this,'log')) {
            $this->log('comment.store','comments',$comment->id,$payload,$request);
        }

        Toastr::success('تم إضافة التعليق');
        return back();
    }

    public function destroy(Request $request, Task $task, Comment $comment)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.comments.destroy')) return $resp;

        // أمان: تأكد إنه تعليق على نفس المهمة
        if (!($comment->entity_type === 'task' && $comment->entity_id == $task->id)) {
            Toastr::error('تعليق غير مطابق.');
            return back();
        }

        $comment->delete();
        Toastr::success('تم حذف التعليق');
        return back();
    }
}
