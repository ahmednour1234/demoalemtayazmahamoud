<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoragesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('storages')->truncate();

        $data = [
            [
                'id' => 1,
                'parent_id' => null,
                'local_id' => 1,
                'name' => 'الخزينة الرئيسية',
                'insert_flag' => 1,
                'created_at' => '2024-08-31 03:57:04',
                'update_flag' => 0,
                'updated_at' => '2024-09-12 15:20:22',
            ],
            [
                'id' => 22,
                'parent_id' => null,
                'local_id' => 0,
                'name' => 'مستودع حفر الباطن',
                'insert_flag' => 1,
                'created_at' => '2024-12-08 08:34:06',
                'update_flag' => 0,
                'updated_at' => '2024-12-08 08:34:19',
            ],
            [
                'id' => 23,
                'parent_id' => null,
                'local_id' => 0,
                'name' => 'الأصول',
                'insert_flag' => 1,
                'created_at' => '2025-02-27 14:56:32',
                'update_flag' => 0,
                'updated_at' => '2025-02-27 14:56:32',
            ],
            [
                'id' => 24,
                'parent_id' => null,
                'local_id' => 0,
                'name' => 'الخصوم',
                'insert_flag' => 1,
                'created_at' => '2025-02-27 14:56:47',
                'update_flag' => 0,
                'updated_at' => '2025-02-27 14:56:47',
            ],
            [
                'id' => 25,
                'parent_id' => null,
                'local_id' => 0,
                'name' => 'حقوق الملكية',
                'insert_flag' => 1,
                'created_at' => '2025-02-27 14:56:59',
                'update_flag' => 0,
                'updated_at' => '2025-02-27 14:56:59',
            ],
            [
                'id' => 26,
                'parent_id' => null,
                'local_id' => 0,
                'name' => 'الإيرادات',
                'insert_flag' => 1,
                'created_at' => '2025-02-27 14:57:13',
                'update_flag' => 0,
                'updated_at' => '2025-02-27 14:57:13',
            ],
            [
                'id' => 27,
                'parent_id' => null,
                'local_id' => 0,
                'name' => 'المصروفات',
                'insert_flag' => 1,
                'created_at' => '2025-02-27 14:57:21',
                'update_flag' => 0,
                'updated_at' => '2025-02-27 14:57:21',
            ],
            [
                'id' => 28,
                'parent_id' => 23,
                'local_id' => 0,
                'name' => 'الأصول المتداولة',
                'insert_flag' => 1,
                'created_at' => '2025-03-03 00:45:33',
                'update_flag' => 0,
                'updated_at' => '2025-02-27 14:56:32',
            ],
            [
                'id' => 29,
                'parent_id' => 23,
                'local_id' => 0,
                'name' => 'الأصول غير متداولة',
                'insert_flag' => 1,
                'created_at' => '2025-03-03 00:45:54',
                'update_flag' => 0,
                'updated_at' => '2025-02-27 14:56:32',
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
                'id' => '`store_id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 30,
            ],
            [
                'id' => 100,
            ],
            [
                'id' => 4,
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
                'id' => 20,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 2550,
            ],
            [
                'id' => 2550,
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
                'id' => 100,
            ],
            [
                'id' => 100,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 45,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 'json_valid(`meta`',
            ],
        ];

        foreach ($data as $row) {
            DB::table('storages')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
