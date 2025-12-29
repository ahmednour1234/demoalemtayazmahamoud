<?php

namespace Database\Seeders\ProjectsAndTasks;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('comments')->truncate();
        DB::statement("-- -- Dumping data for table `comments` -- INSERT INTO `comments` (`id`, `entity_type`, `entity_id`, `admin_id`, `body`, `deleted_at`, `created_at`, `updated_at`) VALUES (1, 'task', 2, 100, 'wwqewq', NULL, '2025-09-07 23:07:24', '2025-09-07 23:07:24');");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
