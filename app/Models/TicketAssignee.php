<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAssignee extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'admin_id',
        'assigned_by_admin_id',
        'is_active',
        'assigned_at',
        'unassigned_at',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'assigned_at'   => 'datetime',
        'unassigned_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_by_admin_id');
    }

    /** Scope للتعيينات النشطة */
    public function scopeActive($q) { return $q->where('is_active', true); }

    /** تعطيل هذا التعيين */
    public function deactivate(): void
    {
        $this->forceFill([
            'is_active'     => false,
            'unassigned_at' => now(),
        ])->save();
    }
}
