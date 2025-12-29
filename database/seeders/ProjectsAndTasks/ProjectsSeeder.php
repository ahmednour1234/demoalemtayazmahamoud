<?php

namespace Database\Seeders\ProjectsAndTasks;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('projects')->truncate();
        DB::statement('--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `code`, `description`, `status_id`, `owner_id`, `lead_id`, `priority`, `start_date`, `due_date`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, \'مدير\', \'09961\', \'dfsdfsd\', 1, 100, NULL, \'medium\', NULL, NULL, 1, NULL, \'2025-09-07 21:38:26\', \'2025-09-07 21:45:12\'),
(2, \'ضريبة صفريه\', \'13123\', \'sdsfasddsa\', 1, 100, NULL, \'medium\', \'2025-09-01\', \'2025-10-10\', 1, NULL, \'2025-09-09 10:24:28\', \'2025-09-09 10:24:28\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
