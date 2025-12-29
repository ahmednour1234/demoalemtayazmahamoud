<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('regions')->truncate();

        $data = [
            [
                'id' => 15,
                'local_id' => 0,
                'name' => 'الرياض',
                'name_en' => null,
                'insert_flag' => 1,
                'created_at' => '2024-12-07 10:34:58',
                'update_flag' => 0,
                'updated_at' => '2025-04-22 08:43:28',
            ],
            [
                'id' => 16,
                'local_id' => 0,
                'name' => 'جدة',
                'name_en' => null,
                'insert_flag' => 1,
                'created_at' => '2024-12-07 10:35:03',
                'update_flag' => 0,
                'updated_at' => '2024-12-07 10:35:03',
            ],
            [
                'id' => 17,
                'local_id' => 0,
                'name' => 'مكة المكرمة',
                'name_en' => null,
                'insert_flag' => 1,
                'created_at' => '2024-12-07 10:35:17',
                'update_flag' => 0,
                'updated_at' => '2024-12-07 10:35:17',
            ],
            [
                'id' => 18,
                'local_id' => 0,
                'name' => 'المدينة المنورة',
                'name_en' => null,
                'insert_flag' => 1,
                'created_at' => '2024-12-07 10:35:27',
                'update_flag' => 0,
                'updated_at' => '2024-12-07 10:35:27',
            ],
            [
                'id' => 19,
                'local_id' => 0,
                'name' => 'حفر الباطن',
                'name_en' => null,
                'insert_flag' => 1,
                'created_at' => '2024-12-07 10:35:39',
                'update_flag' => 0,
                'updated_at' => '2024-12-07 10:35:39',
            ],
            [
                'id' => 21,
                'local_id' => 0,
                'name' => 'الدمام',
                'name_en' => null,
                'insert_flag' => 1,
                'created_at' => '2024-12-07 10:35:59',
                'update_flag' => 0,
                'updated_at' => '2024-12-07 10:35:59',
            ],
            [
                'id' => 24,
                'local_id' => 0,
                'name' => 'الخبر',
                'name_en' => null,
                'insert_flag' => 1,
                'created_at' => '2025-04-22 08:44:18',
                'update_flag' => 0,
                'updated_at' => '2025-04-22 08:44:18',
            ],
            [
                'id' => 25,
                'local_id' => 0,
                'name' => 'الكويت',
                'name_en' => null,
                'insert_flag' => 1,
                'created_at' => '2025-04-22 08:44:31',
                'update_flag' => 0,
                'updated_at' => '2025-04-22 08:44:31',
            ],
            [
                'id' => 28,
                'local_id' => 0,
                'name' => 'الرياض',
                'name_en' => null,
                'insert_flag' => 1,
                'created_at' => '2025-08-17 01:43:38',
                'update_flag' => 0,
                'updated_at' => '2025-08-17 01:43:38',
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
                'id' => 200,
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
                'id' => 20,
            ],
            [
                'id' => 200,
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
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 2550,
            ],
            [
                'id' => 'json_valid(`data`',
            ],
        ];

        foreach ($data as $row) {
            DB::table('regions')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
