<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('accounts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
