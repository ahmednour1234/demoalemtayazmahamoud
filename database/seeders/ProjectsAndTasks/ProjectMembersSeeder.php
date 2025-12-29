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
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
