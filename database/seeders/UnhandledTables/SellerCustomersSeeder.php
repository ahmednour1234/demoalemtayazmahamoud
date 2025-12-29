<?php

namespace Database\Seeders\UnhandledTables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerCustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('seller_customers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
