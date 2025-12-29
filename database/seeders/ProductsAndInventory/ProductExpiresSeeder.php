<?php

namespace Database\Seeders\ProductsAndInventory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductExpiresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_expires')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
