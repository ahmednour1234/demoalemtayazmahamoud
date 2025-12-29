<?php
// app/Models/Department.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id', 'name', 'code', 'active', 'level', 'path',
    ];

    protected $casts = [
        'active' => 'boolean',
        'level'  => 'integer',
    ];

    /* علاقات */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /* سكوبات مفيدة */
    public function scopeActive($q)  { return $q->where('active', true); }
    public function scopeRoots($q)   { return $q->whereNull('parent_id'); }

    /* هيلبرز */
    public function isRoot(): bool   { return is_null($this->parent_id); }

    /* تحديث level/path تلقائياً */
    protected static function booted()
    {
        static::creating(function (self $dept) {
            // مبدئياً قبل الـ save
            if ($dept->parent_id) {
                $parent = self::find($dept->parent_id);
                $dept->level = ($parent->level ?? 0) + 1;
            } else {
                $dept->level = 0;
            }
        });

        static::created(function (self $dept) {
            // حدّث path بعد ما ID يتولد
            if ($dept->parent_id) {
                $parent = self::find($dept->parent_id);
                $dept->path  = rtrim($parent->path ?? ('/'.$parent->id), '/').'/'.$dept->id;
            } else {
                $dept->path = '/'.$dept->id;
            }
            $dept->saveQuietly();
        });

        static::updating(function (self $dept) {
            // لو parent اتغير، أعِد حساب level/path
            if ($dept->isDirty('parent_id')) {
                if ($dept->parent_id) {
                    $parent = self::find($dept->parent_id);
                    $dept->level = ($parent->level ?? 0) + 1;
                    $newPath = rtrim($parent->path ?? ('/'.$parent->id), '/').'/'.$dept->id;
                } else {
                    $dept->level = 0;
                    $newPath = '/'.$dept->id;
                }
                $oldPath = $dept->getOriginal('path');
                $dept->path = $newPath;

                // حدث مسارات/مستويات الأبناء (لو اتغيرت)
                if ($oldPath && $oldPath !== $newPath) {
                    $children = self::where('path', 'like', $oldPath.'/%')->get();
                    foreach ($children as $child) {
                        $child->path = preg_replace('#^'.preg_quote($oldPath,'#').'#', $newPath, $child->path);
                        // أعد حساب level من عدد الشرطات في path
                        $child->level = max(0, substr_count(trim($child->path,'/'), '/'));
                        $child->saveQuietly();
                    }
                }
            }
        });
    }
}
