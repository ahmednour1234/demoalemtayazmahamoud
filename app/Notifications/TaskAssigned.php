<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification
{
    use Queueable;

    public function __construct(public Task $task, public ?Lead $lead = null) {}

    public function via($notifiable): array
    {
        return ['database']; // أضف 'mail' لو ترغب
    }

    public function toArray($notifiable): array
    {
        return [
            'type'     => 'task_assigned',
            'task_id'  => $this->task->id,
            'lead_id'  => $this->lead?->id,
            'title'    => 'تم تكليفك بمهمّة جديدة',
            'message'  => "Task #{$this->task->id}: {$this->task->title}",
            'url'      => route('admin.tasks.show', $this->task->id),
        ];
    }
}
