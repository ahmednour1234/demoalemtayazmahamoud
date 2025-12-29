<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApprovalRequested
{
    use Dispatchable, SerializesModels;

    /**
     * @param string $type  'task' | 'project'
     * @param int    $id
     * @param array<int> $approverIds   admins to notify
     * @param int|null $requestedBy
     */
    public function __construct(
        public string $type,
        public int $id,
        public array $approverIds,
        public ?int $requestedBy = null
    ) {}
}
