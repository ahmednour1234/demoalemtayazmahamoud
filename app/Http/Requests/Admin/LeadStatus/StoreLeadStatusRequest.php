<?php

namespace App\Http\Requests\Admin\LeadStatus;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:100'],
            'code'       => ['required', 'string', 'max:50', 'alpha_dash', 'unique:lead_statuses,code'],
            'sort_order' => ['nullable', 'integer'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الحالة مطلوب.',
            'code.required' => 'الكود مطلوب.',
            'code.unique'   => 'هذا الكود مستخدم من قبل.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => (bool) $this->boolean('is_active'),
        ]);
    }
}
