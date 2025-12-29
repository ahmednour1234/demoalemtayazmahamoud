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
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
