<?php

namespace Database\Seeders\SalesAndCustomerManagement;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('contracts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
