<?php

namespace App\Models;

use App\Enums\ApprovedStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'approved_status',
        'approved_by',
        'approved_at',
        'is_resolved',
        'resolved_by',
        'resolved_at',
        'created_by',
    ];

    protected $casts = [
        'approved_status' => ApprovedStatus::class,
        'is_resolved'     => 'boolean',
        'approved_at'     => 'datetime',
        'resolved_at'     => 'datetime',
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
    ];

    /* ================= العلاقات ================ */

    /** من أنشأ التذكرة */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /** من وافق */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    /** من حل */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'resolved_by');
    }

    /** كل التعليقات */
    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }

    /** كل التعيينات */
    public function assignees(): HasMany
    {
        return $this->hasMany(TicketAssignee::class);
    }

    /** المعيَّن الحالي */
    public function currentAssignee(): HasOne
    {
        return $this->hasOne(TicketAssignee::class)->where('is_active', true)->latestOfMany('assigned_at');
    }

    /* ================= Scopes ================ */

    public function scopePendingApproval($q) { return $q->where('approved_status', ApprovedStatus::PENDING); }
    public function scopeApproved($q)        { return $q->where('approved_status', ApprovedStatus::APPROVED); }
    public function scopeRejected($q)        { return $q->where('approved_status', ApprovedStatus::REJECTED); }
    public function scopeResolved($q)        { return $q->where('is_resolved', true); }
    public function scopeUnresolved($q)      { return $q->where('is_resolved', false); }

    /** تذاكر مُعيّنة حاليًا (اختياري تمرير admin_id) */
    public function scopeWithActiveAssignee($q, ?int $adminId = null)
    {
        return $q->whereHas('assignees', function ($qq) use ($adminId) {
            $qq->where('is_active', true)
               ->when($adminId, fn($w) => $w->where('admin_id', $adminId));
        });
    }

    /* ================= أفعال سريعة ================ */

    public function approve(Admin $by): void
    {
        $this->forceFill([
            'approved_status' => ApprovedStatus::APPROVED,
            'approved_by'     => $by->id,
            'approved_at'     => now(),
        ])->save();
    }

    public function reject(Admin $by): void
    {
        $this->forceFill([
            'approved_status' => ApprovedStatus::REJECTED,
            'approved_by'     => $by->id,
            'approved_at'     => now(),
        ])->save();
    }

    public function markResolved(Admin $by): void
    {
        $this->forceFill([
            'is_resolved' => true,
            'resolved_by' => $by->id,
            'resolved_at' => now(),
        ])->save();
    }

    public function markUnresolved(): void
    {
        $this->forceFill([
            'is_resolved' => false,
            'resolved_by' => null,
            'resolved_at' => null,
        ])->save();
    }

    /**
     * تعيين التذكرة لشخص؛ يُعطّل المعيّن الحالي (لو موجود) ثم يُنشئ تعيين جديد.
     */
    public function assignTo(Admin $assignee, ?Admin $assignedBy = null): TicketAssignee
    {
        // إلغاء تنشيط أي تعيين نشط
        $this->assignees()->where('is_active', true)->update([
            'is_active'     => false,
            'unassigned_at' => now(),
        ]);

        return $this->assignees()->create([
            'admin_id'             => $assignee->id,
            'assigned_by_admin_id' => $assignedBy?->id,
            'is_active'            => true,
            'assigned_at'          => now(),
        ]);
    }

    /** إلغاء التعيين الحالي (إن وجد) */
    public function unassign(?Admin $by = null): void
    {
        $this->assignees()->where('is_active', true)->update([
            'is_active'     => false,
            'unassigned_at' => now(),
        ]);
    }
}
