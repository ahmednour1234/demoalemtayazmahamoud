<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadStatus extends Model
{
    use HasFactory;

    protected $table = 'lead_statuses';
    protected $fillable = ['name', 'code', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'status_id');
    }
}
