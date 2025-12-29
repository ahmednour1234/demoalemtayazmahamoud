<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id', 'admin_id', 'role', 'added_by',
    ];

    // ===== Constants =====
    public const ROLE_OWNER  = 'owner';
    public const ROLE_LEADER = 'leader';
    public const ROLE_MEMBER = 'member';
    public const ROLE_VIEWER = 'viewer';

    // ===== Relationships =====
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(Admin::class, 'added_by');
    }

    // ===== Scopes =====
    public function scopeRole($q, string $role)
    {
        return $q->where('role', $role);
    }

    public function scopeForProject($q, $projectId)
    {
        return $q->where('project_id', $projectId);
    }
}
