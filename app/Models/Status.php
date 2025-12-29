<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    protected $table = 'statuses';

    protected $fillable = [
        'name', 'code', 'color', 'sort_order', 'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // علاقات (اختيارية حسب جداولك)
    public function leads()
    {
        return $this->hasMany(Lead::class, 'status_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'status_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id');
    }
}
