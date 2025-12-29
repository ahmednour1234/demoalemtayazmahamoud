<?php

namespace Database\Seeders\SalesAndCustomerManagement;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationStatusHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('application_status_history')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
