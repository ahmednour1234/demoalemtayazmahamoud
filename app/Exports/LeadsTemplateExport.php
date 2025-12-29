<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromArray, WithHeadings, ShouldAutoSize};

class LeadsTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [
            // صف مثال اختياري
            [
                'ACME LLC','Ahmed Ali','ahmed@example.com','+20','01000111222','01000111222',
                50000,'EGP',4,'new','ads','owner@example.com','2025-08-01 10:00:00','2025-08-10 14:00:00','ملاحظة تجريبية'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'company','contact','email','country_code','phone','whatsapp',
            'potential_value','currency','rating','status_code','source_code','owner_email',
            'last_contact_at','next_action_at','notes'
        ];
    }
}
