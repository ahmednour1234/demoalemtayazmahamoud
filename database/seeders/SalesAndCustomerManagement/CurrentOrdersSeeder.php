<?php

namespace Database\Seeders\SalesAndCustomerManagement;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrentOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('current_orders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
