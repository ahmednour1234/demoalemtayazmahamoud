<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemLog extends Model
{
    use HasFactory;

    protected $table = 'system_logs';
    public $timestamps = false; // لدينا created_at فقط
    protected $fillable = [
        'actor_admin_id','action','table_name','record_id','lead_id',
        'ip_address','user_agent','meta','created_at'
    ];
    protected $casts = ['meta' => 'array', 'created_at' => 'datetime'];

    public function actor() { return $this->belongsTo(Admin::class, 'actor_admin_id'); }
    public function lead()  { return $this->belongsTo(Lead::class,  'lead_id'); }
}
