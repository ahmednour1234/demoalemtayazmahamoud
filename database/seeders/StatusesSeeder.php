<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('statuses')->truncate();

        $data = [
            [
                'id' => 1,
                'name' => 'in_Progress',
                'code' => 'in_Progress',
                'color' => '#55555',
                'sort_order' => 0,
                'active' => 1,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:36:51',
                'updated_at' => '2025-09-07 21:36:57',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 6555,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 4,
            ],
            [
                'id' => 4,
            ],
        ];

        foreach ($data as $row) {
            DB::table('statuses')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
