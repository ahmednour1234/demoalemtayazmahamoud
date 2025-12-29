<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('companies')->truncate();

        $data = [
            [
                'id' => 1,
                'local_id' => 1,
                'company_name' => 'Quality',
                'sub_domain_prefix' => '1',
                'insert_flag' => 1,
                'created_at' => '2024-08-29 04:52:04',
                'update_flag' => 0,
                'updated_at' => '2024-09-01 11:40:34',
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
                'id' => 11,
            ],
            [
                'id' => 11,
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
                'id' => 15,
                'local_id' => 2,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'draft',
                'local_id' => 'active',
                'company_name' => 'completed',
                'sub_domain_prefix' => 'canceled',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 2555,
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
            DB::table('companies')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
