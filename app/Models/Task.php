<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id', 'lead_id', 'title', 'description', 'status_id',
        'priority', 'start_at', 'due_at', 'estimated_minutes', 'actual_minutes',
        'created_by', 'approval_required', 'approval_status', 'approved_by',
        'approved_at', 'rejection_reason', 'next_step_hint',
    ];

    protected $casts = [
        'start_at'          => 'datetime',
        'due_at'            => 'datetime',
        'approval_required' => 'boolean',
        'approved_at'       => 'datetime',
    ];

    // ===== Constants =====
    public const PRIORITY_LOW     = 'low';
    public const PRIORITY_MEDIUM  = 'medium';
    public const PRIORITY_HIGH    = 'high';
    public const PRIORITY_URGENT  = 'urgent';

    public const APPROVAL_PENDING  = 'pending';
    public const APPROVAL_APPROVED = 'approved';
    public const APPROVAL_REJECTED = 'rejected';

    // ===== Relationships =====
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function assignees()
    {
        return $this->hasMany(TaskAssignee::class);
    }

    public function mainAssignees()
    {
        return $this->assignees()->where('role', TaskAssignee::ROLE_ASSIGNEE);
    }

    public function reviewers()
    {
        return $this->assignees()->where('role', TaskAssignee::ROLE_REVIEWER);
    }

    public function watchers()
    {
        return $this->assignees()->where('role', TaskAssignee::ROLE_WATCHER);
    }

    // ===== Scopes =====
    public function scopePriority(Builder $q, string $priority)
    {
        return $q->where('priority', $priority);
    }

    public function scopeStatus(Builder $q, $statusId)
    {
        return $q->where('status_id', $statusId);
    }

    public function scopeOverdue(Builder $q)
    {
        return $q->whereNotNull('due_at')->where('due_at', '<', now());
    }

    public function scopeDueSoon(Builder $q, $hours = 24)
    {
        return $q->whereBetween('due_at', [now(), now()->addHours($hours)]);
    }

    public function scopeNeedingApproval(Builder $q)
    {
        return $q->where('approval_required', true)
                 ->where('approval_status', self::APPROVAL_PENDING);
    }

    public function scopeForUser(Builder $q, $adminId)
    {
        return $q->whereHas('assignees', fn($s) => $s->where('admin_id', $adminId));
    }


    public function followUps()
    {
        // جدول follow_ups فيه عمود task_id (حسب الـ SQL اللي عملته)
        return $this->hasMany(FollowUp::class, 'task_id')->orderByDesc('next_follow_up_at');
    }

    public function comments()
    {
        // تعليقات خاصة بالمهمة (entity_type = 'task')
        return $this->hasMany(Comment::class, 'entity_id')
            ->where('entity_type', 'task')
            ->orderByDesc('id');
    }
}
