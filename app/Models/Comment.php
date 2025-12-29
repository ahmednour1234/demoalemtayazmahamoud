<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'entity_type','entity_id','admin_id','body',
    ];

    // Relations
    public function admin() { return $this->belongsTo(Admin::class); }

    // Helpers
    public function target()
    {
        return match ($this->entity_type) {
            'task'    => Task::find($this->entity_id),
            'project' => Project::find($this->entity_id),
            'lead'    => Lead::find($this->entity_id),
            default   => null,
        };
    }
}
