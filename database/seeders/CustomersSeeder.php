<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('customers')->truncate();

        $data = [
            [
                'id' => 1,
                'local_id' => 0,
                'name' => 'الكاشير',
                'name_en' => 'Default Customer',
                'mobile' => '1',
                'email' => null,
                'image' => null,
                'state' => null,
                'city' => null,
                'zip_code' => null,
                'address' => null,
                'balance' => 1235.938,
                'credit' => 7450.6944117147,
                'type' => 0,
                'latitude' => null,
                'longitude' => null,
                'active' => 1,
                'limit' => 0,
                'insert_flag' => 1,
                'created_at' => null,
                'update_flag' => 0,
                'updated_at' => '2025-08-15 04:24:53',
                'company_id' => 1,
                'category_id' => null,
                'specialist' => 1,
                'region_id' => 1,
                'pharmacy_name' => null,
                'tax_number' => '0',
                'c_history' => '0',
                'discount' => 0,
                'account_id' => 92,
                'guarantor_id' => null,
            ],
            [
                'id' => 15,
                'local_id' => 0,
                'name' => 'سالم فهد عبدالخالق الزهراني',
                'name_en' => null,
                'mobile' => '0568708838',
                'email' => 'alemtayaz@gmail.com',
                'image' => 'def.png',
                'state' => '1',
                'city' => 'الرياض',
                'zip_code' => '12244',
                'address' => 'الأمير فيصل بن سعد بن عبدالرحمن',
                'balance' => null,
                'credit' => 0,
                'type' => 1,
                'latitude' => '30.0444',
                'longitude' => '31.2357',
                'active' => 1,
                'limit' => 0,
                'insert_flag' => 1,
                'created_at' => '2025-09-29 18:50:11',
                'update_flag' => 0,
                'updated_at' => '2025-09-29 18:52:31',
                'company_id' => 1,
                'category_id' => null,
                'specialist' => 1,
                'region_id' => 0,
                'pharmacy_name' => null,
                'tax_number' => '1',
                'c_history' => '1',
                'discount' => 0,
                'account_id' => 363,
                'guarantor_id' => null,
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
                'id' => 20,
            ],
            [
                'id' => 4,
            ],
            [
                'id' => 4,
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
                'id' => '`id` bigint(20',
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
                'id' => 'json_valid(`options`',
            ],
            [
                'id' => 'json_valid(`default_value`',
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
        ];

        foreach ($data as $row) {
            DB::table('customers')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
