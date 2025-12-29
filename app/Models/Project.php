<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'code', 'description', 'status_id', 'owner_id', 'lead_id',
        'priority', 'start_date', 'due_date', 'active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date'   => 'date',
        'active'     => 'boolean',
    ];

    // ===== Constants =====
    public const PRIORITY_LOW     = 'low';
    public const PRIORITY_MEDIUM  = 'medium';
    public const PRIORITY_HIGH    = 'high';
    public const PRIORITY_URGENT  = 'urgent';

    // ===== Relationships =====
    public function owner()
    {
        return $this->belongsTo(Admin::class, 'owner_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function members()
    {
        return $this->hasMany(ProjectMember::class);
    }

    public function leaders()
    {
        return $this->members()->where('role', ProjectMember::ROLE_LEADER);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // ===== Scopes =====
    public function scopeActive($q, bool $active = true)
    {
        return $q->where('active', $active);
    }

    public function scopePriority($q, $priority)
    {
        return $q->where('priority', $priority);
    }

    public function scopeOwnedBy($q, $adminId)
    {
        return $q->where('owner_id', $adminId);
    }

    public function scopeDueBetween($q, $from, $to)
    {
        return $q->whereBetween('due_date', [$from, $to]);
    }
}
