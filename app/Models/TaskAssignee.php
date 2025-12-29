<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskAssignee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'task_id', 'admin_id', 'role', 'priority', 'due_at', 'assigned_by', 'assigned_at',
    ];

    protected $casts = [
        'due_at'      => 'datetime',
        'assigned_at' => 'datetime',
    ];

    // ===== Constants =====
    public const ROLE_ASSIGNEE = 'assignee';
    public const ROLE_REVIEWER = 'reviewer';
    public const ROLE_WATCHER  = 'watcher';

    public const PRIORITY_LOW     = 'low';
    public const PRIORITY_MEDIUM  = 'medium';
    public const PRIORITY_HIGH    = 'high';
    public const PRIORITY_URGENT  = 'urgent';

    // ===== Relationships =====
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(Admin::class, 'assigned_by');
    }

    // ===== Scopes =====
    public function scopeRole($q, string $role)
    {
        return $q->where('role', $role);
    }

    public function scopePriority($q, string $priority)
    {
        return $q->where('priority', $priority);
    }

    public function scopeOverdue($q)
    {
        return $q->whereNotNull('due_at')->where('due_at', '<', now());
    }
}
