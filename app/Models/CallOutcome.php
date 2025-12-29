<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CallOutcome extends Model
{
    use HasFactory;

    protected $table = 'call_outcomes';
    protected $fillable = ['name', 'code'];

    public function callLogs()
    {
        return $this->hasMany(CallLog::class, 'outcome_id');
    }
}
