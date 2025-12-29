<?php

namespace Database\Seeders\SettingsAndSystem;

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
        DB::statement('--
-- Dumping data for table `custom_fields`
--

INSERT INTO `custom_fields` (`id`, `name`, `key`, `type`, `options`, `default_value`, `is_required`, `is_active`, `sort_order`, `applies_to`, `group`, `help_text`, `created_at`, `updated_at`) VALUES
(1, \'رقم الجواز\', \'nationality_Id\', \'text\', NULL, NULL, 1, 1, 1, \'App\\\\Models\\\\Lead\', NULL, NULL, \'2025-08-23 20:27:52\', \'2025-09-10 01:15:54\'),
(2, \'الجنسية\', \'nationality\', \'text\', NULL, NULL, 1, 0, 2, \'App\\\\Models\\\\Lead\', NULL, NULL, \'2025-08-23 20:28:40\', \'2025-09-09 18:15:48\'),
(3, \'مدة الوقت للرد\', \'response_time\', \'datetime\', NULL, NULL, 1, 1, 1, \'App\\\\Models\\\\CallLog\', NULL, NULL, \'2025-08-23 21:10:39\', \'2025-09-09 18:15:21\'),
(4, \'رقم الجوال الاخير\', \'last_phone\', \'text\', NULL, NULL, 1, 0, 0, \'App\\\\Models\\\\LeadNote\', NULL, NULL, \'2025-08-23 22:21:12\', \'2025-09-09 18:15:46\'),
(5, \'رقم الهوية\', \'number_Identity\', \'number\', NULL, NULL, 0, 1, 0, \'App\\\\Models\\\\Customer\', NULL, NULL, \'2025-09-29 18:20:43\', \'2025-09-29 18:20:43\'),
(6, \'الاعتماد\', \'5\', \'text\', NULL, NULL, 0, 1, 0, \'App\\\\Models\\\\Lead\', NULL, NULL, \'2025-12-09 00:41:49\', \'2025-12-09 00:41:49\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
