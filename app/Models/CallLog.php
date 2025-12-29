<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasCustomFields;

class CallLog extends Model
{
    use HasFactory;
    use HasCustomFields;

    protected $table = 'call_logs';

    protected $fillable = [
        'lead_id','admin_id','direction','started_at','ended_at',
        'outcome_id','phone_used','channel','recording_url','notes'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function lead()   { return $this->belongsTo(Lead::class, 'lead_id'); }
    public function admin()  { return $this->belongsTo(Admin::class, 'admin_id'); }
    public function outcome(){ return $this->belongsTo(CallOutcome::class, 'outcome_id'); }
}
