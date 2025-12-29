<?php
namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use App\Models\CustomField;


class CustomFieldRequest extends FormRequest
{
public function authorize(): bool { return true; }


public function rules(): array
{
$id = $this->route('custom_field')?->id;
return [
'name' => ['required','string','max:120'],
'key' => ['required','alpha_dash','max:120','unique:custom_fields,key,'.($id??'NULL').',id'],
'type' => ['required','in:'.implode(',', CustomField::types())],
'options' => ['nullable','array'],
'default_value' => ['nullable','array'],
'is_required' => ['boolean'],
'is_active' => ['boolean'],
'sort_order' => ['integer','min:0'],
'applies_to' => ['required','string','max:255'],
'group' => ['nullable','string','max:120'],
'help_text' => ['nullable','string','max:255'],
];
}


protected function prepareForValidation(): void
{
// دعم إدخال JSON كنص من الفورم
$opts = $this->input('options');
$defv = $this->input('default_value');
$this->merge([
'options' => is_string($opts) && $opts !== '' ? json_decode($opts, true) : $opts,
'default_value' => is_string($defv) && $defv !== '' ? json_decode($defv, true) : $defv,
'is_required' => (bool)$this->input('is_required'),
'is_active' => (bool)$this->input('is_active', true),
'sort_order' => (int)$this->input('sort_order', 0),
]);
}
}
