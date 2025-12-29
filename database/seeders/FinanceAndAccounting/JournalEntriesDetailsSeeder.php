<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JournalEntriesDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('journal_entries_details')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
