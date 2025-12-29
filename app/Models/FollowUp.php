<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FollowUp extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'task_id','project_id','lead_id',
        'created_by','assigned_to',
        'next_follow_up_at','status','comment',
        'lost_at','lost_reason',
    ];

    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_DONE      = 'done';
    public const STATUS_SKIPPED   = 'skipped';
    public const STATUS_LOST      = 'lost';

    protected $casts = [
        'next_follow_up_at' => 'datetime',
        'lost_at' => 'datetime',
    ];

    // Relations
    public function task()    { return $this->belongsTo(Task::class); }
    public function project() { return $this->belongsTo(Project::class); }
    public function lead()    { return $this->belongsTo(Lead::class); }
    public function creator() { return $this->belongsTo(Admin::class, 'created_by'); }
    public function owner()   { return $this->belongsTo(Admin::class, 'assigned_to'); }

    // Scopes
    public function scopeAssignedTo($q, $adminId) { return $q->where('assigned_to', $adminId); }
    public function scopeStatus($q, $status)      { return $q->where('status', $status); }
}
