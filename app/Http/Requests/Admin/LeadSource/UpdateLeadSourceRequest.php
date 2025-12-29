<?php
// app/Http/Requests/Admin/LeadSource/UpdateLeadSourceRequest.php

namespace App\Http\Requests\Admin\LeadSource;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadSourceRequest extends FormRequest
{
    public function authorize(): bool { return auth('admin')->check(); }

    public function rules(): array
    {
        $id = $this->route('source')?->id ?? null;

        return [
            'name'       => ['required','string','max:100'],
            'code'       => ['required','string','max:50','alpha_dash', Rule::unique('lead_sources','code')->ignore($id)],
            'sort_order' => ['nullable','integer'],
            'is_active'  => ['nullable','boolean'],
        ];
    }
}
