<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'approvable_type','approvable_id',
        'requested_by','approver_id',
        'status','reason','next_step_hint','decided_at',
    ];

    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $casts = [
        'decided_at' => 'datetime',
    ];

    // Relations
    public function requester() { return $this->belongsTo(Admin::class, 'requested_by'); }
    public function approver()  { return $this->belongsTo(Admin::class, 'approver_id'); }

    // Target helper
    public function approvable()
    {
        return match ($this->approvable_type) {
            'task'    => Task::find($this->approvable_id),
            'project' => Project::find($this->approvable_id),
            'lead'    => Lead::find($this->approvable_id),
            default   => null,
        };
    }
}
