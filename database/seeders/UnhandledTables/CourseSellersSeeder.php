<?php

namespace Database\Seeders\UnhandledTables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('course_sellers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
