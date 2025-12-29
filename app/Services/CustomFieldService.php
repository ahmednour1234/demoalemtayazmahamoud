<?php

namespace App\Services;

use App\Models\CustomField;
use App\Models\CustomFieldValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CustomFieldService
{
    public function fieldsFor(string $fqcn, bool $activeOnly = true)
    {
        $cacheKey = "custom_fields:{$fqcn}:".($activeOnly?'1':'0');
        return Cache::remember($cacheKey, 600, function () use ($fqcn, $activeOnly) {
            $q = CustomField::query()->where('applies_to', $fqcn);
            if ($activeOnly) $q->where('is_active', true);
            return $q->orderBy('sort_order')->get();
        });
    }

    /** خريطة القيم الحالية بالمفتاح */
    public function valuesMapFor(Model $fieldable): array
    {
        $values = CustomFieldValue::query()
            ->where('fieldable_type', get_class($fieldable))
            ->where('fieldable_id', $fieldable->getKey())
            ->with('customField:id,key,type')
            ->get();

        $out = [];
        foreach ($values as $v) {
            $key = $v->customField?->key;
            if (!$key) continue;

            $out[$key] = $this->normalizedValueForShow(
                $v->customField->type,
                $v->value,
                $v->value_json
            );
        }
        return $out;
    }

    /** يبني قواعد التحقق بناءً على تعريف الحقول */
    public function rulesFor(string $fqcn): array
    {
        $rules = [];
        foreach ($this->fieldsFor($fqcn) as $field) {
            $name = "custom_fields.{$field->key}";
            $base = [];

            if ($field->is_required) $base[] = 'required';
            else $base[] = 'nullable';

            switch ($field->type) {
                case 'text':
                case 'textarea':
                    $base[] = 'string';
                    break;

                case 'number':
                    $base[] = 'numeric';
                    break;

                case 'boolean':
                    $base[] = 'boolean';
                    break;

                case 'date':
                    $base[] = 'date';
                    break;

                case 'datetime':
                    $base[] = 'date';
                    break;

                case 'select':
                    $base[] = 'in:'.implode(',', Arr::wrap($field->options ?? []));
                    break;

                case 'multiselect':
                    $base[] = 'array';
                    $base[] = 'min:'.($field->is_required ? 1 : 0);
                    $rules["{$name}.*"] = 'in:'.implode(',', Arr::wrap($field->options ?? []));
                    break;

                case 'json':
                    $base[] = 'array';
                    break;
            }

            $rules[$name] = implode('|', $base);
        }
        return $rules;
    }

    /** يحفظ القيم (إنشاء/تحديث) حسب النوع */
    public function save(Model $fieldable, array $input, ?string $fqcn = null): void
    {
        $fqcn = $fqcn ?: get_class($fieldable);
        $fields = $this->fieldsFor($fqcn);

        foreach ($fields as $field) {
            $key = $field->key;
            if (!Arr::has($input, $key)) {
                // لو الحقل مش جاي بالريكويست وماهوش required، سيبه زي ما هو
                continue;
            }

            $raw = Arr::get($input, $key);

            // تجهيز القيمة لحفظها (value / value_json)
            $value = null;
            $valueJson = null;

            switch ($field->type) {
                case 'boolean':
                    $value = filter_var($raw, FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
                    break;

                case 'number':
                    $value = is_numeric($raw) ? (string)$raw : null;
                    break;

                case 'date':
                    $value = $raw ? Carbon::parse($raw)->toDateString() : null;
                    break;

                case 'datetime':
                    // خزنها كنص ISO أو DATETIME متسق
                    $value = $raw ? Carbon::parse($raw)->toDateTimeString() : null;
                    break;

                case 'select':
                case 'text':
                case 'textarea':
                    $value = isset($raw) ? (string)$raw : null;
                    break;

                case 'multiselect':
                case 'json':
                    $valueJson = is_array($raw) ? $raw : (array) $raw;
                    break;
            }

            CustomFieldValue::query()->updateOrCreate(
                [
                    'custom_field_id' => $field->id,
                    'fieldable_type'  => get_class($fieldable),
                    'fieldable_id'    => $fieldable->getKey(),
                ],
                [
                    'value'      => $value,
                    'value_json' => $valueJson,
                ]
            );
        }
    }

    /** قيمة جاهزة للعرض */
    protected function normalizedValueForShow(string $type, ?string $value, ?array $valueJson)
    {
        return match ($type) {
            'multiselect', 'json' => $valueJson,
            'boolean'             => $value === '1' || $value === 1 || $value === true,
            default               => $value,
        };
    }
}
