<?php
// app/Http/Requests/Admin/LeadSource/StoreLeadSourceRequest.php

namespace App\Http\Requests\Admin\LeadSource;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadSourceRequest extends FormRequest
{
    public function authorize(): bool { return auth('admin')->check(); }

    public function rules(): array
    {
        return [
            'name'       => ['required','string','max:100'],
            'code'       => ['required','string','max:50','alpha_dash','unique:lead_sources,code'],
            'sort_order' => ['nullable','integer'],
            'is_active'  => ['nullable','boolean'],
        ];
    }
}
