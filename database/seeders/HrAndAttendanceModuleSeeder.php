<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HrAndAttendanceModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\HrAndAttendance\AttendancesSeeder::class);
        $this->call(\Database\Seeders\HrAndAttendance\GuarantorsSeeder::class);
        $this->call(\Database\Seeders\HrAndAttendance\InterviewEvaluationsSeeder::class);
        $this->call(\Database\Seeders\HrAndAttendance\JobApplicantsSeeder::class);
        $this->call(\Database\Seeders\HrAndAttendance\ShiftsSeeder::class);

    }
}
