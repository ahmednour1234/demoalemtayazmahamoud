<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerCustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('seller_customers')->truncate();

        $data = [
            [
                'id' => 5782,
                'local_id' => 0,
                'customer_id' => 15,
                'seller_id' => 163,
                'created_at' => '2025-09-29 15:50:11',
                'updated_at' => '2025-09-29 15:50:11',
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
                'id' => '`id` int(11',
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
                'id' => 2555,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 2550,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
        ];

        foreach ($data as $row) {
            DB::table('seller_customers')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
