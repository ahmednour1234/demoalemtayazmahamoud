<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('admin_sellers')->truncate();

        $data = [
            [
                'id' => 70,
                'admin_id' => 162,
                'seller_id' => 100,
                'created_at' => '2025-08-30 15:32:43',
                'updated_at' => '2025-08-30 15:32:43',
            ],
            [
                'id' => 71,
                'admin_id' => 162,
                'seller_id' => 159,
                'created_at' => '2025-08-30 15:32:43',
                'updated_at' => '2025-08-30 15:32:43',
            ],
            [
                'id' => 72,
                'admin_id' => 162,
                'seller_id' => 160,
                'created_at' => '2025-08-30 15:32:43',
                'updated_at' => '2025-08-30 15:32:43',
            ],
            [
                'id' => 73,
                'admin_id' => 162,
                'seller_id' => 161,
                'created_at' => '2025-08-30 15:32:43',
                'updated_at' => '2025-08-30 15:32:43',
            ],
            [
                'id' => '`id` int(11',
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 50,
            ],
            [
                'id' => 50,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 'task',
                'admin_id' => 'project',
                'seller_id' => 'lead',
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
                'id' => 'pending',
                'admin_id' => 'approved',
                'seller_id' => 'rejected',
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => '`id` int(10',
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
                'admin_id' => 2,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => '`id` int(10',
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
                'admin_id' => 2,
            ],
            [
                'id' => 10,
                'admin_id' => 2,
            ],
            [
                'id' => '`id` int(11',
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 15,
                'admin_id' => 2,
            ],
            [
                'id' => 15,
                'admin_id' => 2,
            ],
            [
                'id' => 15,
                'admin_id' => 2,
            ],
            [
                'id' => '`purchase_price` + `additional_costs`',
            ],
            [
                'id' => 15,
                'admin_id' => 2,
            ],
            [
                'id' => 15,
                'admin_id' => 2,
            ],
            [
                'id' => 15,
                'admin_id' => 2,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 'straight_line',
                'admin_id' => 'declining_balance',
                'seller_id' => 'units_of_production',
            ],
            [
                'id' => 5,
                'admin_id' => 2,
            ],
            [
                'id' => 100,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 'active',
                'admin_id' => 'maintenance',
                'seller_id' => 'disposed',
                'created_at' => 'sold',
                'updated_at' => 'closed',
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 11,
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
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 50,
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
                'id' => 'مادة خام أو وسيط',
            ],
            [
                'id' => 16,
                'admin_id' => 4,
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
                'id' => 20,
            ],
            [
                'id' => 11,
            ],
        ];

        foreach ($data as $row) {
            DB::table('admin_sellers')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
