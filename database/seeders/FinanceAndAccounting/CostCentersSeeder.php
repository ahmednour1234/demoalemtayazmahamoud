<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cost_centers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
