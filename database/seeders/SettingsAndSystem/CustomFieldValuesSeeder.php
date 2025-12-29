<?php

namespace Database\Seeders\SettingsAndSystem;

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
        DB::statement('INSERT INTO `custom_field_values` (`id`, `custom_field_id`, `fieldable_type`, `fieldable_id`, `value`, `value_json`, `created_at`, `updated_at`) VALUES
(1, 1, \'App\\\\Models\\\\Lead\', 7, \'ffggf3434\', NULL, \'2025-08-23 20:52:44\', \'2025-09-10 01:16:14\'),
(2, 2, \'App\\\\Models\\\\Lead\', 7, \'\', NULL, \'2025-08-23 20:52:44\', \'2025-08-23 20:52:44\'),
(3, 1, \'App\\\\Models\\\\Lead\', 8, \'12345678\', NULL, \'2025-08-23 20:53:25\', \'2025-08-23 20:53:25\'),
(4, 2, \'App\\\\Models\\\\Lead\', 8, \'سعودي\', NULL, \'2025-08-23 20:53:25\', \'2025-08-23 20:53:25\'),
(5, 3, \'App\\\\Models\\\\CallLog\', 3, \'2025-09-05T21:46\', NULL, \'2025-08-23 21:46:49\', \'2025-08-23 21:46:49\'),
(6, 4, \'App\\\\Models\\\\LeadNote\', 2, \'012254877897\', NULL, \'2025-08-23 22:21:39\', \'2025-08-23 22:21:39\'),
(7, 3, \'App\\\\Models\\\\CallLog\', 6, \'2025-09-06T22:23\', NULL, \'2025-08-23 22:23:07\', \'2025-08-23 22:23:07\'),
(19, 5, \'App\\\\Models\\\\Customer\', 15, \'569498779879\', NULL, \'2025-09-29 18:50:11\', \'2025-09-29 18:52:31\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
