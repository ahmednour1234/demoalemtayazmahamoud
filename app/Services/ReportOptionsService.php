<?php

namespace App\Services;

use Illuminate\Http\Request;

class ReportOptionsService
{
    public function fromRequest(Request $request): array
    {
        return [
            // Report type
            'report_basis' => $request->input('report_basis', 'general'), // general|accounts|level
            'account_level' => (int) $request->input('account_level', 1),

            // Date
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),

            // Toggles
            'with_opening_balance' => (bool) $request->boolean('with_opening_balance'),
            'show_first_income'    => (bool) $request->boolean('show_first_income'),

            // Company file fields
            'company' => [
                'logo'       => (bool) $request->boolean('company_logo'),
                'cr'         => (bool) $request->boolean('company_cr'),
                'tax'        => (bool) $request->boolean('company_tax'),
                'email'      => (bool) $request->boolean('company_email'),
                'address'    => (bool) $request->boolean('company_address'),
                'phone'      => (bool) $request->boolean('company_phone'),
                'fax'        => (bool) $request->boolean('company_fax'),
            ],

            // Signatures
            'signatures' => [
                'general_manager'  => (bool) $request->boolean('sig_general_manager'),
                'finance_manager'  => (bool) $request->boolean('sig_finance_manager'),
                'financial_auditor'=> (bool) $request->boolean('sig_financial_auditor'),
                'accountant'       => (bool) $request->boolean('sig_accountant'),
            ],

            // Render flags
            'preview' => (bool) $request->boolean('preview'),
        ];
    }
}
