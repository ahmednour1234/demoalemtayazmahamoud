<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('brands')->truncate();

        $data = [
            [
                'id' => 1,
                'local_id' => 1,
                'name' => 'كواليتى',
                'image' => '',
                'insert_flag' => 1,
                'created_at' => '2024-08-28 23:43:22',
                'update_flag' => 0,
                'updated_at' => '2024-09-01 11:40:32',
                'company_id' => 1,
            ],
            [
                'id' => 2,
                'local_id' => 2,
                'name' => 'دايموند ',
                'image' => '',
                'insert_flag' => 1,
                'created_at' => '2024-08-28 23:43:22',
                'update_flag' => 0,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 3,
                'local_id' => 3,
                'name' => 'ساين',
                'image' => '',
                'insert_flag' => 1,
                'created_at' => '2024-08-28 23:43:22',
                'update_flag' => 0,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 4,
                'local_id' => 4,
                'name' => 'اكسبشن',
                'image' => '',
                'insert_flag' => 1,
                'created_at' => '2024-08-28 23:49:10',
                'update_flag' => 0,
                'updated_at' => null,
                'company_id' => 1,
            ],
            [
                'id' => 5,
                'local_id' => 5,
                'name' => 'مارين',
                'image' => '',
                'insert_flag' => 1,
                'created_at' => '2024-08-28 23:49:10',
                'update_flag' => 0,
                'updated_at' => null,
                'company_id' => 1,
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
        ];

        foreach ($data as $row) {
            DB::table('brands')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
