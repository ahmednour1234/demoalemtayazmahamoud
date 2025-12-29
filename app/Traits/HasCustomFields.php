<?php
namespace App\Traits;

use App\Models\CustomField;
use App\Models\CustomFieldValue;
use Illuminate\Support\Arr;

trait HasCustomFields
{
    public function customFieldValues()
    {
        return $this->morphMany(CustomFieldValue::class, 'fieldable');
    }

    public function customFieldDefinitions()
    {
        return CustomField::forModel(static::class)->get();
    }

    public function getCustomFieldsArrayAttribute(): array
    {
        $defs = $this->customFieldDefinitions();
        $vals = $this->customFieldValues->keyBy('custom_field_id');
        $out = [];
        foreach ($defs as $def) {
            $val = $vals->get($def->id);
            $out[$def->key] = $this->castValueOut($def->type, $val?->value, $val?->value_json, $def->default_value);
        }
        return $out;
    }

    public function syncCustomFields(array $input): void
    {
        $defs = $this->customFieldDefinitions()->keyBy('key');
        foreach ($input as $key => $val) {
            $def = $defs->get($key);
            if (!$def) continue;
            [$value, $valueJson] = $this->castValueIn($def->type, $val);
            $this->customFieldValues()->updateOrCreate(
                ['custom_field_id' => $def->id],
                ['value' => $value, 'value_json' => $valueJson]
            );
        }
    }

    protected function castValueIn(string $type, $val): array
    {
        switch ($type) {
            case 'multiselect':
            case 'json':
                return [null, Arr::wrap($val)];
            case 'boolean':
                return [$val ? '1' : '0', null];
            case 'number':
                return [is_numeric($val) ? (string)$val : null, null];
            case 'date':
            case 'datetime':
                return [$val ? (string)$val : null, null];
            default:
                return [$val !== '' ? (string)$val : null, null];
        }
    }

    protected function castValueOut(string $type, $value, $valueJson, $default = null)
    {
        if ($valueJson !== null) return $valueJson;
        if ($value === null) return $default;
        return match($type){
            'boolean' => $value === '1',
            'number'  => is_numeric($value) ? 0 + $value : null,
            default   => $value,
        };
    }
}
