<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('custom_fields')->truncate();

        $data = [
            [
                'id' => 1,
                'name' => 'رقم الجواز',
                'key' => 'nationality_Id',
                'type' => 'text',
                'options' => null,
                'default_value' => null,
                'is_required' => 1,
                'is_active' => 1,
                'sort_order' => 1,
                'applies_to' => 'App\\Models\\Lead',
                'group' => null,
                'help_text' => null,
                'created_at' => '2025-08-23 20:27:52',
                'updated_at' => '2025-09-10 01:15:54',
            ],
            [
                'id' => 2,
                'name' => 'الجنسية',
                'key' => 'nationality',
                'type' => 'text',
                'options' => null,
                'default_value' => null,
                'is_required' => 1,
                'is_active' => 0,
                'sort_order' => 2,
                'applies_to' => 'App\\Models\\Lead',
                'group' => null,
                'help_text' => null,
                'created_at' => '2025-08-23 20:28:40',
                'updated_at' => '2025-09-09 18:15:48',
            ],
            [
                'id' => 3,
                'name' => 'مدة الوقت للرد',
                'key' => 'response_time',
                'type' => 'datetime',
                'options' => null,
                'default_value' => null,
                'is_required' => 1,
                'is_active' => 1,
                'sort_order' => 1,
                'applies_to' => 'App\\Models\\CallLog',
                'group' => null,
                'help_text' => null,
                'created_at' => '2025-08-23 21:10:39',
                'updated_at' => '2025-09-09 18:15:21',
            ],
            [
                'id' => 4,
                'name' => 'رقم الجوال الاخير',
                'key' => 'last_phone',
                'type' => 'text',
                'options' => null,
                'default_value' => null,
                'is_required' => 1,
                'is_active' => 0,
                'sort_order' => 0,
                'applies_to' => 'App\\Models\\LeadNote',
                'group' => null,
                'help_text' => null,
                'created_at' => '2025-08-23 22:21:12',
                'updated_at' => '2025-09-09 18:15:46',
            ],
            [
                'id' => 5,
                'name' => 'رقم الهوية',
                'key' => 'number_Identity',
                'type' => 'number',
                'options' => null,
                'default_value' => null,
                'is_required' => 0,
                'is_active' => 1,
                'sort_order' => 0,
                'applies_to' => 'App\\Models\\Customer',
                'group' => null,
                'help_text' => null,
                'created_at' => '2025-09-29 18:20:43',
                'updated_at' => '2025-09-29 18:20:43',
            ],
            [
                'id' => 6,
                'name' => 'الاعتماد',
                'key' => '5',
                'type' => 'text',
                'options' => null,
                'default_value' => null,
                'is_required' => 0,
                'is_active' => 1,
                'sort_order' => 0,
                'applies_to' => 'App\\Models\\Lead',
                'group' => null,
                'help_text' => null,
                'created_at' => '2025-12-09 00:41:49',
                'updated_at' => '2025-12-09 00:41:49',
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
                'id' => 20,
            ],
            [
                'id' => 'json_valid(`value_json`',
            ],
        ];

        foreach ($data as $row) {
            DB::table('custom_fields')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
