<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class CustomField extends Model
{
protected $fillable = [
'name', 'key', 'type', 'options', 'default_value', 'is_required', 'is_active', 'sort_order', 'applies_to', 'group', 'help_text'
];


protected $casts = [
'options' => 'array',
'default_value' => 'array',
'is_required' => 'boolean',
'is_active' => 'boolean',
'sort_order' => 'integer',
];


public function scopeForModel($q, string $fqcn)
{
return $q->where('applies_to', $fqcn)->where('is_active', true)->orderBy('sort_order');
}


public static function types(): array
{
return ['text','textarea','number','boolean','date','datetime','select','multiselect','json'];
}
}