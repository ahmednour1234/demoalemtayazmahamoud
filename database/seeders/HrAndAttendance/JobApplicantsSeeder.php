<?php

namespace Database\Seeders\HrAndAttendance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobApplicantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('job_applicants')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
