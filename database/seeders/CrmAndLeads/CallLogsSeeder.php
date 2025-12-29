<?php

namespace Database\Seeders\CrmAndLeads;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CallLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('call_logs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
