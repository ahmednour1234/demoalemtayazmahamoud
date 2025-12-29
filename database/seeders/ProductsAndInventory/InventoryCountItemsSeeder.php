<?php

namespace Database\Seeders\ProductsAndInventory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryCountItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('inventory_count_items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
