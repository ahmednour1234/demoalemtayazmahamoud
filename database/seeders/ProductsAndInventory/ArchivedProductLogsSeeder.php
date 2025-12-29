<?php

namespace Database\Seeders\ProductsAndInventory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArchivedProductLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('archived_product_logs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
