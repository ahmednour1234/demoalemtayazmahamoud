<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomFieldValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('custom_field_values')->truncate();

        $data = [
            [
                'id' => 1,
                'custom_field_id' => 1,
                'fieldable_type' => 'App\\Models\\Lead',
                'fieldable_id' => 7,
                'value' => 'ffggf3434',
                'value_json' => null,
                'created_at' => '2025-08-23 20:52:44',
                'updated_at' => '2025-09-10 01:16:14',
            ],
            [
                'id' => 2,
                'custom_field_id' => 2,
                'fieldable_type' => 'App\\Models\\Lead',
                'fieldable_id' => 7,
                'value' => '',
                'value_json' => null,
                'created_at' => '2025-08-23 20:52:44',
                'updated_at' => '2025-08-23 20:52:44',
            ],
            [
                'id' => 3,
                'custom_field_id' => 1,
                'fieldable_type' => 'App\\Models\\Lead',
                'fieldable_id' => 8,
                'value' => '12345678',
                'value_json' => null,
                'created_at' => '2025-08-23 20:53:25',
                'updated_at' => '2025-08-23 20:53:25',
            ],
            [
                'id' => 4,
                'custom_field_id' => 2,
                'fieldable_type' => 'App\\Models\\Lead',
                'fieldable_id' => 8,
                'value' => 'سعودي',
                'value_json' => null,
                'created_at' => '2025-08-23 20:53:25',
                'updated_at' => '2025-08-23 20:53:25',
            ],
            [
                'id' => 5,
                'custom_field_id' => 3,
                'fieldable_type' => 'App\\Models\\CallLog',
                'fieldable_id' => 3,
                'value' => '2025-09-05T21:46',
                'value_json' => null,
                'created_at' => '2025-08-23 21:46:49',
                'updated_at' => '2025-08-23 21:46:49',
            ],
            [
                'id' => 6,
                'custom_field_id' => 4,
                'fieldable_type' => 'App\\Models\\LeadNote',
                'fieldable_id' => 2,
                'value' => '012254877897',
                'value_json' => null,
                'created_at' => '2025-08-23 22:21:39',
                'updated_at' => '2025-08-23 22:21:39',
            ],
            [
                'id' => 7,
                'custom_field_id' => 3,
                'fieldable_type' => 'App\\Models\\CallLog',
                'fieldable_id' => 6,
                'value' => '2025-09-06T22:23',
                'value_json' => null,
                'created_at' => '2025-08-23 22:23:07',
                'updated_at' => '2025-08-23 22:23:07',
            ],
            [
                'id' => 19,
                'custom_field_id' => 5,
                'fieldable_type' => 'App\\Models\\Customer',
                'fieldable_id' => 15,
                'value' => '569498779879',
                'value_json' => null,
                'created_at' => '2025-09-29 18:50:11',
                'updated_at' => '2025-09-29 18:52:31',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 191,
            ],
            [
                'id' => 64,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 5,
            ],
            [
                'id' => 1024,
            ],
        ];

        foreach ($data as $row) {
            DB::table('custom_field_values')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
