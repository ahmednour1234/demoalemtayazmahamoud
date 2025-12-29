<?php

namespace Database\Seeders\HrAndAttendance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuarantorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('guarantors')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
