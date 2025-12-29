<?php

namespace App\Models\Concerns;

use App\Services\CustomFieldService;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasCustomFields
{
    public function customFieldValues(): MorphMany
    {
        return $this->morphMany(\App\Models\CustomFieldValue::class, 'fieldable');
    }

    public function customFieldsService(): CustomFieldService
    {
        return app(CustomFieldService::class);
    }

    public function customFields(): \Illuminate\Support\Collection
    {
        return $this->customFieldsService()->fieldsFor(static::class);
    }

    public function saveCustomFields(array $input): void
    {
        $this->customFieldsService()->save($this, $input, static::class);
    }

    public function customFieldsValuesMap(): array
    {
        return $this->customFieldsService()->valuesMapFor($this);
    }
}
