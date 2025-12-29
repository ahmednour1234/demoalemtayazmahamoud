<?php

namespace Database\Seeders\SupportAndOthers;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('faqs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
