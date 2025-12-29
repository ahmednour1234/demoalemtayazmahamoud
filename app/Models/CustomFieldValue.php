<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class CustomFieldValue extends Model
{
protected $fillable = ['custom_field_id','fieldable_type','fieldable_id','value','value_json'];


protected $casts = [ 'value_json' => 'array' ];


public function customField(){ return $this->belongsTo(CustomField::class, 'custom_field_id'); }
public function fieldable(){ return $this->morphTo(); }
}