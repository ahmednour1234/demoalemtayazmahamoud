<?php

namespace Database\Seeders\ProjectsAndTasks;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tasks')->truncate();
        DB::statement('INSERT INTO `tasks` (`id`, `project_id`, `lead_id`, `title`, `description`, `status_id`, `priority`, `start_at`, `due_at`, `estimated_minutes`, `actual_minutes`, `created_by`, `approval_required`, `approval_status`, `approved_by`, `approved_at`, `rejection_reason`, `next_step_hint`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, \'gfgf\', \'dfdfd\', 1, \'medium\', \'2025-08-31 21:48:00\', \'2025-10-11 21:48:00\', 5000, NULL, 100, 1, \'rejected\', 100, \'2025-09-07 22:26:35\', \'qde\', \'weqq\', \'2025-09-07 22:39:01\', \'2025-09-07 21:49:06\', \'2025-09-07 22:39:01\'),
(2, 1, NULL, \'sfdsfsd\', \'dsfdsf\', 1, \'medium\', \'2025-09-09 22:39:00\', \'2025-10-06 22:39:00\', 2332, NULL, 100, 0, \'pending\', NULL, NULL, NULL, NULL, NULL, \'2025-09-07 22:39:30\', \'2025-09-07 19:54:39\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
