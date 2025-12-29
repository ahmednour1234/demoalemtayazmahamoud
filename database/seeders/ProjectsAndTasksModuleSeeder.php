<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectsAndTasksModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\ProjectsAndTasks\CommentsSeeder::class);
        $this->call(\Database\Seeders\ProjectsAndTasks\ProjectsSeeder::class);
        $this->call(\Database\Seeders\ProjectsAndTasks\ProjectMembersSeeder::class);
        $this->call(\Database\Seeders\ProjectsAndTasks\TasksSeeder::class);
        $this->call(\Database\Seeders\ProjectsAndTasks\TaskAssigneesSeeder::class);

    }
}
