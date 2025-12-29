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
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
