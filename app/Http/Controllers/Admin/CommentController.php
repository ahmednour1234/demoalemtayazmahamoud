<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\WithAdminGate;
use App\Models\Comment;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use App\Services\NotificationService;

class CommentController extends Controller
{
    use WithAdminGate;

    public function store(Request $request)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.comment')) return $resp;

        $data = $request->validate([
            'entity_type' => ['required','in:task,project,lead'],
            'entity_id'   => ['required','integer'],
            'body'        => ['required','string'],
        ]);

        $comment = Comment::create([
            'entity_type' => $data['entity_type'],
            'entity_id'   => $data['entity_id'],
            'admin_id'    => Auth::guard('admin')->id(),
            'body'        => $data['body'],
        ]);

        // إشعار أصحاب العلاقة (بسيط: بلّغ صاحب الكيان لو معروف)
        $title = 'تعليق جديد';
        $body  = mb_substr($comment->body, 0, 120);
        $payload = ['entity_type'=>$comment->entity_type, 'entity_id'=>$comment->entity_id, 'comment_id'=>$comment->id];

        // مثال: لو الكيان Task — بلّغ منشئ المهمة/المنفذين (حسب ما هو متاح عندك)
        if ($comment->entity_type === 'task') {
            $task = \App\Models\Task::with(['assignees','creator'])->find($comment->entity_id);
            if ($task) {
                $targets = [];
                if ($task->creator) $targets[] = $task->creator->id;
                foreach ($task->assignees as $a) $targets[] = $a->admin_id;
                $targets = array_unique($targets);
                foreach ($targets as $uid) {
                    if ($uid != Auth::guard('admin')->id()) {
                        NotificationService::push($uid, 'comment.task', $title, $body, $payload);
                    }
                }
            }
        }

        $this->log('comment.store','comments',$comment->id, $payload, $request);
        Toastr::success('تم إضافة التعليق');
        return back();
    }

    public function destroy(Request $request, Comment $comment)
    {
        if ($resp = $this->ensurePermissionOrBack($request, 'task.comment')) return $resp;

        $comment->delete();
        $this->log('comment.destroy','comments',$comment->id, [], $request);
        Toastr::success('تم حذف التعليق');
        return back();
    }
}
