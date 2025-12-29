<?php

namespace App\Http\Requests\Admin\Lead;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool { return auth('admin')->check(); }

    public function rules(): array
    {
        return [
            'owner_id'   => ['nullable','integer','exists:admins,id'],
            'status_id'  => ['nullable','integer','exists:lead_statuses,id'],
            'source_id'  => ['nullable','integer','exists:lead_sources,id'],

            'company_name' => ['nullable','string','max:150'],
            'contact_name' => ['nullable','string','max:150'],
            'email'        => ['nullable','email','max:150'],
            'country_code' => ['required','string','max:8'],
            'phone'        => ['required','string','max:30'],
            'whatsapp'     => ['nullable','string','max:30'],

            'potential_value' => ['nullable','numeric'],
            'currency'        => ['nullable','string','size:3'],
            'rating'          => ['nullable','integer','between:1,5'],
            'pipeline_notes'  => ['nullable','string','max:5000'],
            'last_contact_at' => ['nullable','date'],
            'next_action_at'  => ['nullable','date'],
            'is_archived'     => ['nullable','boolean'],
        ];
    }
}
