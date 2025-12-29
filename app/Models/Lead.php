<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasCustomFields;

class Lead extends Model
{
    use HasFactory;
    use HasCustomFields;

    protected $table = 'leads';

    protected $fillable = [
        'owner_id','created_by_admin_id','updated_by_admin_id',
        'status_id','source_id',
        'company_name','contact_name','email',
        'country_code','phone','whatsapp',
        'potential_value','currency','rating',
        'pipeline_notes','last_contact_at','next_action_at',
        'is_archived'
    ];

    protected $casts = [
        'potential_value' => 'decimal:2',
        'rating'          => 'integer',
        'is_archived'     => 'boolean',
        'last_contact_at' => 'datetime',
        'next_action_at'  => 'datetime',
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
    ];
public function members()
{
    return $this->belongsToMany(Admin::class, 'lead_assignments', 'lead_id', 'assigned_to_admin_id')
                ->withTimestamps();
}
public function assignees()
{
    return $this->belongsToMany(
        Admin::class,
        'lead_assignments',          // اسم جدول الربط
        'lead_id',                   // FK على جدول leads
        'assigned_to_admin_id'       // FK على جدول admins
    )->withTimestamps();
}
    // علاقات
    public function owner()     { return $this->belongsTo(Admin::class, 'owner_id'); }
    public function createdBy() { return $this->belongsTo(Admin::class, 'created_by_admin_id'); }
    public function updatedBy() { return $this->belongsTo(Admin::class, 'updated_by_admin_id'); }
    public function status()    { return $this->belongsTo(LeadStatus::class, 'status_id'); }
    public function source()    { return $this->belongsTo(LeadSource::class, 'source_id'); }
public function systemLogs(){ return $this->hasMany(\App\Models\SystemLog::class, 'lead_id'); }

    public function callLogs()  { return $this->hasMany(CallLog::class, 'lead_id'); }
    public function notes()     { return $this->hasMany(LeadNote::class, 'lead_id'); }
    public function assignments(){ return $this->hasMany(LeadAssignment::class, 'lead_id'); }
    public function tasks()     { return $this->hasMany(LeadTask::class, 'lead_id'); }

    // حقول مشتقة (اختيارية)
    public function getPhoneNormalizedAttribute()
    {
        // الحقل موجود Generated في DB، دي fallback لو احتجت الوصول من Eloquent
        $cc = trim((string)$this->country_code);
        $ph = preg_replace('/\D+/', '', (string)$this->phone);
        return trim($cc . ' ' . $ph);
    }

    // Scopes مفيدة
    public function scopeSearch($q, ?string $term)
    {
        if (!$term) return $q;
        return $q->where(function ($qq) use ($term) {
            $qq->where('company_name', 'like', "%$term%")
               ->orWhere('contact_name', 'like', "%$term%")
               ->orWhere('email', 'like', "%$term%")
               ->orWhere('phone', 'like', "%$term%");
        });
    }

    public function scopeStatusCode($q, ?string $code)
    {
        if (!$code) return $q;
        return $q->whereHas('status', fn($s) => $s->where('code', $code));
    }

    public function scopeSourceCode($q, ?string $code)
    {
        if (!$code) return $q;
        return $q->whereHas('source', fn($s) => $s->where('code', $code));
    }
}
