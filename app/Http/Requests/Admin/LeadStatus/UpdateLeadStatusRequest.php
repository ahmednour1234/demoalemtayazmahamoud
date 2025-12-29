<?php

namespace App\Http\Requests\Admin\LeadStatus;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->route('status')?->id ?? null;

        return [
            'name'       => ['required', 'string', 'max:100'],
            'code'       => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('lead_statuses', 'code')->ignore($id)],
            'sort_order' => ['nullable', 'integer'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => (bool) $this->boolean('is_active'),
        ]);
    }
}
