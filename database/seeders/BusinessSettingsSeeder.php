<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('business_settings')->truncate();

        $data = [
            [
                'id' => 1,
                'key' => 'shop_logo',
                'value' => '2025-09-11-68c2e9dced961.png',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 2,
                'key' => 'pagination_limit',
                'value' => '100000',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 3,
                'key' => 'currency',
                'value' => 'SAR',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 4,
                'key' => 'shop_name',
                'value' => 'شركة الامتياز للاستقدام',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 5,
                'key' => 'shop_address',
                'value' => 'الرياض',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 6,
                'key' => 'shop_phone',
                'value' => '011421806',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 7,
                'key' => 'shop_email',
                'value' => 'alemtayaz@gmail.com',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 8,
                'key' => 'footer_text',
                'value' => 'شركة الامتياز للاستقدام',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 9,
                'key' => 'country',
                'value' => 'AF',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 10,
                'key' => 'stock_limit',
                'value' => '10',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 11,
                'key' => 'time_zone',
                'value' => 'Pacific/Midway',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 12,
                'key' => 'vat_reg_no',
                'value' => '302251044300003',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 13,
                'key' => 'kilometer',
                'value' => '0',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 14,
                'key' => 'number_tax',
                'value' => '302251044300003',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 15,
                'key' => 'color1',
                'value' => '#000000',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 16,
                'key' => 'color2',
                'value' => '#f2ba02',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 17,
                'key' => 'base_url',
                'value' => 'https://testnewpos.iqbrandx.com/',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 18,
                'key' => 'cash',
                'value' => '1',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 19,
                'key' => 'shabaka',
                'value' => '1',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 20,
                'key' => 'agel',
                'value' => '1',
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 21,
                'key' => 'credit',
                'value' => null,
                'created_at' => null,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 22,
                'key' => 'tax',
                'value' => null,
                'created_at' => '2025-02-23 17:10:02',
                'updated_at' => '2025-02-23 17:10:02',
                'company_id' => 1,
            ],
            [
                'id' => 23,
                'key' => 'opening_balance_account_id',
                'value' => '297',
                'created_at' => '2025-09-11 18:20:00',
                'updated_at' => '2025-09-11 18:20:00',
                'company_id' => 1,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'inbound',
                'key' => 'outbound',
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 'if(`ended_at` is null',
                'key' => null,
                'value' => 'timestampdiff(SECOND',
                'created_at' => '`started_at`',
                'updated_at' => '`ended_at`',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 40,
            ],
            [
                'id' => 'phone',
                'key' => 'whatsapp',
                'value' => 'zoom',
                'created_at' => 'teams',
                'updated_at' => 'other',
            ],
            [
                'id' => 255,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 100,
            ],
            [
                'id' => 50,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 4,
            ],
            [
                'id' => 4,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 50,
            ],
            [
                'id' => 100,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 'task',
                'key' => 'project',
                'value' => 'lead',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
        ];

        foreach ($data as $row) {
            DB::table('business_settings')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
