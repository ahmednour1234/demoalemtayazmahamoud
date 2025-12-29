<?php

namespace Database\Seeders\SettingsAndSystem;

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
        DB::statement('--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `local_id`, `name`, `name_en`, `insert_flag`, `created_at`, `update_flag`, `updated_at`) VALUES
(15, 0, \'الرياض\', NULL, 1, \'2024-12-07 10:34:58\', 0, \'2025-04-22 08:43:28\'),
(16, 0, \'جدة\', NULL, 1, \'2024-12-07 10:35:03\', 0, \'2024-12-07 10:35:03\'),
(17, 0, \'مكة المكرمة\', NULL, 1, \'2024-12-07 10:35:17\', 0, \'2024-12-07 10:35:17\'),
(18, 0, \'المدينة المنورة\', NULL, 1, \'2024-12-07 10:35:27\', 0, \'2024-12-07 10:35:27\'),
(19, 0, \'حفر الباطن\', NULL, 1, \'2024-12-07 10:35:39\', 0, \'2024-12-07 10:35:39\'),
(21, 0, \'الدمام\', NULL, 1, \'2024-12-07 10:35:59\', 0, \'2024-12-07 10:35:59\'),
(24, 0, \'الخبر\', NULL, 1, \'2025-04-22 08:44:18\', 0, \'2025-04-22 08:44:18\'),
(25, 0, \'الكويت\', NULL, 1, \'2025-04-22 08:44:31\', 0, \'2025-04-22 08:44:31\'),
(28, 0, \'الرياض\', NULL, 1, \'2025-08-17 01:43:38\', 0, \'2025-08-17 01:43:38\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
