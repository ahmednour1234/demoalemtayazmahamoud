<?php

namespace Database\Seeders\UnhandledTables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevelopSellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('develop_sellers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
