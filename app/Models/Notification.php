<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'type', 'title', 'body', 'data', 'read_at',
    ];

    protected $casts = [
        'data'    => 'array',      // JSON → Array
        'read_at' => 'datetime',
    ];

    // ============ Relationships ============
    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    // ============ Scopes ============
    public function scopeUnread($q)
    {
        return $q->whereNull('read_at');
    }

    public function scopeRead($q)
    {
        return $q->whereNotNull('read_at');
    }

    public function scopeType($q, string $type)
    {
        return $q->where('type', $type);
    }

    // ============ Helpers ============
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
    }

    public function markAsUnread()
    {
        $this->update(['read_at' => null]);
    }

    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }
}
