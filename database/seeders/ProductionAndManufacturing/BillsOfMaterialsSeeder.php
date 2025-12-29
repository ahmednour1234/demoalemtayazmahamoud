<?php

namespace Database\Seeders\ProductionAndManufacturing;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillsOfMaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('bills_of_materials')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
