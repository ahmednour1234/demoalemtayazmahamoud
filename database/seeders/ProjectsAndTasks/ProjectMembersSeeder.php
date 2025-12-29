<?php

namespace Database\Seeders\ProjectsAndTasks;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('project_members')->truncate();
        DB::statement("-- -- Dumping data for table `project_members` -- INSERT INTO `project_members` (`id`, `project_id`, `admin_id`, `role`, `added_by`, `deleted_at`, `created_at`, `updated_at`) VALUES (1, 1, 159, 'member', 100, NULL, '2025-09-07 21:47:25', '2025-09-07 21:47:25'), (2, 1, 160, 'member', 100, NULL, '2025-09-07 21:47:32', '2025-09-07 21:47:32'), (3, 1, 100, 'member', 100, '2025-09-07 21:47:52', '2025-09-07 21:47:36', '2025-09-07 21:47:52'), (4, 1, 162, 'leader', 100, NULL, '2025-09-07 21:47:41', '2025-09-07 21:47:41'), (5, 1, 161, 'member', 100, NULL, '2025-09-07 21:48:00', '2025-09-07 21:48:00'), (7, 2, 160, 'member', 100, NULL, '2025-09-09 10:24:41', '2025-09-09 10:24:41'), (8, 2, 159, 'member', 100, NULL, '2025-09-09 10:24:46', '2025-09-09 10:24:46');");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
