<?php

namespace Database\Seeders\SupportAndOthers;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ticket_comments')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
