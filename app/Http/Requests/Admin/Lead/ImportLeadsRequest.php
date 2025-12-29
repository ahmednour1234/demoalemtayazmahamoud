<?php

namespace App\Http\Requests\Admin\Lead;

use Illuminate\Foundation\Http\FormRequest;

class ImportLeadsRequest extends FormRequest
{
    public function authorize(): bool { return auth('admin')->check(); }

    public function rules(): array
    {
        return [
            'file' => ['required','file','mimes:xlsx,csv'],
            // اختيارياً
            'default_owner' => ['nullable','integer','exists:admins,id'],
            // لو عايز توزيع تلقائي على مجموعة محددة
            'distribute'    => ['nullable','boolean'],
            'admin_ids'     => ['nullable','array'],
            'admin_ids.*'   => ['integer','exists:admins,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'distribute' => (bool)$this->boolean('distribute'),
        ]);
    }
}
