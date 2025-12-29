<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApprovalDecided
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $type,              // task | project
        public int $id,
        public string $status,            // approved | rejected
        public ?int $decidedBy = null,
        public ?string $reason = null,
        public ?string $nextStepHint = null
    ) {}
}
