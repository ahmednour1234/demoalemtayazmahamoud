<?php

namespace Database\Seeders\ProductionAndManufacturing;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('work_centers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
