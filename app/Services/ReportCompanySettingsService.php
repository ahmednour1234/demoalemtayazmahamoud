<?php

namespace App\Services;

use App\Models\BusinessSetting;

class ReportCompanySettingsService
{
    public function get(): array
    {
        $bs = BusinessSetting::whereIn('key', [
            'vat_reg_no','number_tax','shop_email','shop_logo','shop_name','shop_address','shop_phone'
        ])->pluck('value', 'key');

        return [
            'vatRegNo'  => $bs['vat_reg_no'] ?? '',
            'taxNo'     => $bs['number_tax'] ?? '',
            'shopEmail' => $bs['shop_email'] ?? '',
            'shopLogo'  => $bs['shop_logo'] ?? '',
            'shopName'  => $bs['shop_name'] ?? '',
            'shopAddr'  => $bs['shop_address'] ?? '',
            'shopPhone' => $bs['shop_phone'] ?? '',
        ];
    }
}
