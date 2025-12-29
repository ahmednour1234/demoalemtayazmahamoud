<?php

namespace Database\Seeders\SupportAndOthers;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('maintenance_logs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
