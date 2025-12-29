<?php

namespace Database\Seeders;

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

        $data = [
            [
                'id' => 1,
                'name' => 'دوام صباحي',
                'start' => '10:00:00',
                'end' => '18:00:00',
                'breake' => 20,
                'created_at' => '2025-02-24 20:25:51',
                'updated_at' => '2025-09-09 17:42:26',
                'kilometer' => '0',
                'active' => 1,
                'max' => 20,
                'number_shifts' => 0,
                'hours_of_each_shift' => 0,
            ],
            [
                'id' => 2,
                'name' => 'دوام مسائي',
                'start' => '01:00:00',
                'end' => '21:00:00',
                'breake' => 20,
                'created_at' => '2025-04-17 09:29:03',
                'updated_at' => '2025-09-09 17:43:24',
                'kilometer' => '0',
                'active' => 1,
                'max' => 20,
                'number_shifts' => 0,
                'hours_of_each_shift' => 0,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 255,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 191,
            ],
            [
                'id' => 64,
            ],
            [
                'id' => 32,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 1,
            ],
        ];

        foreach ($data as $row) {
            DB::table('shifts')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
