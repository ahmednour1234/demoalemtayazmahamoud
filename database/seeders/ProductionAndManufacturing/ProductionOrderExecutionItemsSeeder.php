<?php

namespace Database\Seeders\ProductionAndManufacturing;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionOrderExecutionItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('production_order_execution_items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
