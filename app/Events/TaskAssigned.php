<?php

namespace App\Events;

use App\Models\Task;
use App\Models\Admin;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssigned
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Task $task,
        public Admin $assignee,
        public ?Admin $assignedBy = null
    ) {}
}
