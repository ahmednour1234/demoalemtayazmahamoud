<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadAssignment extends Model
{
    use HasFactory;

    protected $table = 'lead_assignments';
    public $timestamps = false; // لدينا assigned_at فقط

    protected $fillable = [
        'lead_id','assigned_to_admin_id','assigned_by_admin_id','assigned_at','reason'
    ];
    protected $casts = ['assigned_at' => 'datetime'];

    public function lead()     { return $this->belongsTo(Lead::class,  'lead_id'); }
    public function assignedTo(){ return $this->belongsTo(Admin::class, 'assigned_to_admin_id'); }
    public function assignedBy(){ return $this->belongsTo(Admin::class, 'assigned_by_admin_id'); }
}
