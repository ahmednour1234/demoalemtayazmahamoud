<?php

namespace Database\Seeders\HrAndAttendance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('shifts')->truncate();
        DB::statement("-- -- Dumping data for table `shifts` -- INSERT INTO `shifts` (`id`, `name`, `start`, `end`, `breake`, `created_at`, `updated_at`, `kilometer`, `active`, `max`, `number_shifts`, `hours_of_each_shift`) VALUES (1, 'دوام صباحي', '10:00:00', '18:00:00', 20, '2025-02-24 20:25:51', '2025-09-09 17:42:26', '0', 1, 20, 0, 0), (2, 'دوام مسائي', '01:00:00', '21:00:00', 20, '2025-04-17 09:29:03', '2025-09-09 17:43:24', '0', 1, 20, 0, 0);");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
