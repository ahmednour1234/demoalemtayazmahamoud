<?php

namespace Database\Seeders\CrmAndLeads;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowUpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('follow_ups')->truncate();
        DB::statement("-- -- Dumping data for table `follow_ups` -- INSERT INTO `follow_ups` (`id`, `task_id`, `project_id`, `lead_id`, `created_by`, `assigned_to`, `next_follow_up_at`, `status`, `comment`, `lost_at`, `lost_reason`, `deleted_at`, `created_at`, `updated_at`) VALUES (1, 2, NULL, NULL, 100, NULL, '2025-09-18 22:35:00', 'done', 'jbjnun', NULL, NULL, NULL, '2025-09-07 22:36:04', '2025-09-07 23:14:32'), (2, 1, NULL, NULL, 100, NULL, '2025-09-18 22:35:00', 'scheduled', 'jbjnun', NULL, NULL, NULL, '2025-09-07 22:36:24', '2025-09-07 19:50:36'), (3, NULL, NULL, NULL, 100, NULL, '2025-10-01 22:38:00', 'scheduled', 'jbjnun', NULL, NULL, NULL, '2025-09-07 22:38:27', '2025-09-07 22:38:27'), (4, NULL, NULL, NULL, 100, NULL, '2025-10-01 22:38:00', 'scheduled', 'jbjnun', NULL, NULL, NULL, '2025-09-07 22:38:41', '2025-09-07 22:38:41'), (5, NULL, NULL, NULL, 100, NULL, '2025-09-02 22:41:00', 'scheduled', 'jbjnun', NULL, NULL, NULL, '2025-09-07 22:41:14', '2025-09-07 22:41:14'), (6, NULL, NULL, NULL, 100, NULL, '2025-09-06 22:49:00', 'scheduled', 'jbjnun', NULL, NULL, NULL, '2025-09-07 22:50:00', '2025-09-07 22:50:00'), (7, 2, NULL, NULL, 100, NULL, '2025-09-09 10:27:00', 'done', 'ddd', NULL, NULL, NULL, '2025-09-09 10:27:48', '2025-09-09 10:32:07');");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
