<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Models\Notification;

class SendTaskAssignedNotification
{
    public function handle(TaskAssigned $event): void
    {
        Notification::create([
            'user_id' => $event->assignee->id,
            'type'    => 'task.assigned',
            'title'   => 'تم إسناد مهمة جديدة',
            'body'    => 'عنوان المهمة: ' . $event->task->title,
            'data'    => [
                'task_id' => $event->task->id,
                'assigned_by' => $event->assignedBy?->id,
            ],
        ]);
    }
}
