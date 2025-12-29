<?php

namespace App\Listeners;

use App\Events\ApprovalDecided;
use App\Models\Notification;
use App\Models\Task;
use App\Models\Project;

class SendApprovalDecidedNotification
{
    public function handle(ApprovalDecided $event): void
    {
        // نبعت لصاحب العنصر + المكلّفين (لو Task)
        $userIds = [];

        if ($event->type === 'task') {
            $task = Task::with(['creator','assignees'])->find($event->id);
            if (!$task) return;
            $userIds[] = $task->created_by;
            $userIds = array_merge($userIds, $task->assignees->pluck('admin_id')->all());
        } elseif ($event->type === 'project') {
            $project = Project::with(['owner','members'])->find($event->id);
            if (!$project) return;
            $userIds[] = $project->owner_id;
            $userIds = array_merge($userIds, $project->members->pluck('admin_id')->all());
        }

        $userIds = array_values(array_unique($userIds));

        foreach ($userIds as $uid) {
            Notification::create([
                'user_id' => $uid,
                'type'    => 'approval.decision',
                'title'   => $event->status === 'approved' ? 'تمت الموافقة' : 'تم الرفض',
                'body'    => $event->status === 'approved'
                    ? 'تم اعتماد العنصر.'
                    : ('تم رفض الطلب. السبب: ' . ($event->reason ?? '-')),
                'data'    => [
                    'type' => $event->type,
                    'id' => $event->id,
                    'status' => $event->status,
                    'decided_by' => $event->decidedBy,
                    'next_step_hint' => $event->nextStepHint,
                ],
            ]);
        }
    }
}
