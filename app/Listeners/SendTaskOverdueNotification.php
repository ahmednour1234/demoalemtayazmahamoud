<?php

namespace App\Listeners;

use App\Events\TaskOverdue;
use App\Models\Notification;

class SendTaskOverdueNotification
{
    public function handle(TaskOverdue $event): void
    {
        // ننبّه كل المكلّفين بالمهمة
        $assignees = $event->task->assignees()->pluck('admin_id');
        foreach ($assignees as $adminId) {
            Notification::create([
                'user_id' => $adminId,
                'type'    => 'task.overdue',
                'title'   => 'تنبيه: مهمة متأخرة',
                'body'    => 'المهمة "' . $event->task->title . '" تجاوزت موعدها.',
                'data'    => ['task_id' => $event->task->id],
            ]);
        }
    }
}
