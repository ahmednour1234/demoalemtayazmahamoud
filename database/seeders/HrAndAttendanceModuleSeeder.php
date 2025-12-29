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
        $this->call(\Database\Seeders\HrAndAttendance\ShiftsSeeder::class);

    }
}
