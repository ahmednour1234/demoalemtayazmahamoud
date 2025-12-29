<?php

namespace Database\Seeders\AuthAndUserManagement;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('admin_sellers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
