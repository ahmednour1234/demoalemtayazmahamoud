<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthPersonalAccessClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('oauth_personal_access_clients')->truncate();

        $data = [
            [
                'id' => 1,
                'client_id' => 1,
                'created_at' => '2022-07-27 12:47:21',
                'updated_at' => '2022-07-27 12:47:21',
            ],
            [
                'id' => '`id` varchar(100',
            ],
            [
                'id' => 100,
            ],
            [
                'id' => 1,
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
                'id' => 20,
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
                'id' => 10,
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
                'id' => 255,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 222,
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
                'id' => 20,
            ],
            [
                'id' => 6555,
            ],
            [
                'id' => 20,
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
            [
                'id' => 11,
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
                'id' => 20,
            ],
            [
                'id' => 20,
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
                'id' => 20,
            ],
            [
                'id' => 20,
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
                'id' => 20,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => '`email` varchar(255',
            ],
            [
                'id' => 255,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 50,
            ],
            [
                'id' => 'payment',
                'client_id' => 'receipt',
            ],
            [
                'id' => 255,
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
                'id' => 15,
                'client_id' => 2,
            ],
            [
                'id' => 3,
            ],
            [
                'id' => 'cash',
                'client_id' => 'bank_transfer',
                'created_at' => 'cheque',
                'updated_at' => 'other',
            ],
            [
                'id' => 100,
            ],
            [
                'id' => 255,
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
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 64,
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
                'id' => 12,
                'client_id' => 2,
            ],
            [
                'id' => 12,
                'client_id' => 2,
            ],
            [
                'id' => 12,
                'client_id' => 2,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 'open',
                'client_id' => 'closed',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'بدون FK',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'بدون FK',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'بدون FK',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'بدون FK',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'بدون FK',
            ],
            [
                'id' => 10,
                'client_id' => 2,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 'draft',
                'client_id' => 'planned',
                'created_at' => 'in_progress',
                'updated_at' => 'completed',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'بدون قيد FK',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'بدون قيد FK',
            ],
            [
                'id' => 10,
                'client_id' => 2,
            ],
            [
                'id' => 10,
                'client_id' => 2,
            ],
            [
                'id' => 10,
                'client_id' => 2,
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
                'id' => 6,
                'client_id' => 2,
            ],
            [
                'id' => 10,
                'client_id' => 2,
            ],
            [
                'id' => 10,
                'client_id' => 2,
            ],
            [
                'id' => 10,
                'client_id' => 2,
            ],
            [
                'id' => 10,
                'client_id' => 2,
            ],
            [
                'id' => 15,
                'client_id' => 4,
            ],
            [
                'id' => 15,
                'client_id' => 4,
            ],
            [
                'id' => 'json_valid(`additional_costs`',
            ],
            [
                'id' => 15,
                'client_id' => 4,
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
                'id' => 20,
            ],
            [
                'id' => 10,
                'client_id' => 2,
            ],
            [
                'id' => 10,
                'client_id' => 2,
            ],
            [
                'id' => 15,
                'client_id' => 4,
            ],
            [
                'id' => 15,
                'client_id' => 4,
            ],
            [
                'id' => 15,
                'client_id' => 4,
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
                'id' => 255,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 8,
                'client_id' => 2,
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
                'id' => 8,
                'client_id' => 2,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 8,
                'client_id' => 2,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 10,
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
            [
                'id' => 10,
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
                'id' => 255,
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
                'id' => 255,
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
                'id' => 20,
            ],
            [
                'id' => 20,
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
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 2555,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 191,
            ],
            [
                'id' => 64,
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
                'id' => 'low',
                'client_id' => 'medium',
                'created_at' => 'high',
                'updated_at' => 'urgent',
            ],
            [
                'id' => 1,
            ],
        ];

        foreach ($data as $row) {
            DB::table('oauth_personal_access_clients')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
