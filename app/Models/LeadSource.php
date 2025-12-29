<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadSource extends Model
{
    use HasFactory;

    protected $table = 'lead_sources';
    protected $fillable = ['name', 'code'];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'source_id');
    }
}
