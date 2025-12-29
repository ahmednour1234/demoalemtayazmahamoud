<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomFields;

class LeadNote extends Model
{
    use HasCustomFields;

    protected $fillable = [
        'lead_id','admin_id','note','visibility',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // علاقات أساسية
    public function lead(){ return $this->belongsTo(Lead::class); }
    public function admin(){ return $this->belongsTo(Admin::class); }
}
