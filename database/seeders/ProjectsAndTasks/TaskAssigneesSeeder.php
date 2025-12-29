<?php

namespace Database\Seeders\ProjectsAndTasks;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskAssigneesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('task_assignees')->truncate();
        DB::statement("-- -- Dumping data for table `task_assignees` -- INSERT INTO `task_assignees` (`id`, `task_id`, `admin_id`, `role`, `priority`, `due_at`, `assigned_by`, `assigned_at`, `deleted_at`, `created_at`, `updated_at`) VALUES (1, 1, 159, 'assignee', 'medium', '2025-10-11 21:48:00', 100, '2025-09-07 18:49:06', NULL, '2025-09-07 21:49:06', '2025-09-07 21:49:06'), (2, 1, 160, 'assignee', 'medium', '2025-10-11 21:48:00', 100, '2025-09-07 18:49:06', NULL, '2025-09-07 21:49:06', '2025-09-07 21:49:06'), (3, 1, 161, 'assignee', 'medium', '2025-10-11 21:48:00', 100, '2025-09-07 18:49:06', '2025-09-07 22:19:29', '2025-09-07 21:49:06', '2025-09-07 22:19:29'), (4, 1, 162, 'assignee', 'medium', '2025-10-11 21:48:00', 100, '2025-09-07 18:49:06', '2025-09-07 22:19:26', '2025-09-07 21:49:06', '2025-09-07 22:19:26'), (5, 1, 159, 'reviewer', 'urgent', '2025-09-25 22:19:00', 100, '2025-09-07 19:19:20', NULL, '2025-09-07 22:19:20', '2025-09-07 22:19:20'), (6, 2, 159, 'assignee', 'medium', '2025-10-06 22:39:00', 100, '2025-09-07 19:39:30', NULL, '2025-09-07 22:39:30', '2025-09-07 22:39:30'), (7, 2, 160, 'assignee', 'medium', '2025-10-06 22:39:00', 100, '2025-09-07 19:39:30', NULL, '2025-09-07 22:39:30', '2025-09-07 22:39:30'), (8, 2, 161, 'assignee', 'medium', '2025-10-06 22:39:00', 100, '2025-09-07 19:39:30', NULL, '2025-09-07 22:39:30', '2025-09-07 22:39:30'), (9, 2, 162, 'assignee', 'medium', '2025-10-06 22:39:00', 100, '2025-09-07 19:39:30', NULL, '2025-09-07 22:39:30', '2025-09-07 22:39:30');");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
