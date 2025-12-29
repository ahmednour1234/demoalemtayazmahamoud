<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cost_centers')->truncate();

        $data = [
            [
                'id' => 1,
                'name' => 'فرع حفرالباطن',
                'code' => '123',
                'description' => 'فرع حفرالباطن',
                'parent_id' => 1,
                'active' => 1,
                'created_at' => '2025-04-28 05:19:45',
                'updated_at' => '2025-09-12 11:05:17',
                'deleted_at' => null,
            ],
            [
                'id' => 14,
                'name' => 'فرع الرياض',
                'code' => '1',
                'description' => '',
                'parent_id' => 14,
                'active' => 1,
                'created_at' => '2025-09-11 17:20:44',
                'updated_at' => '2025-09-11 17:50:25',
                'deleted_at' => null,
            ],
            [
                'id' => 15,
                'name' => 'فرع الرياض',
                'code' => '1111',
                'description' => 'فرع الرياض',
                'parent_id' => 15,
                'active' => 1,
                'created_at' => '2025-09-11 17:21:20',
                'updated_at' => '2025-09-12 11:04:35',
                'deleted_at' => null,
            ],
            [
                'id' => 16,
                'name' => 'فرع الرياض',
                'code' => '11111',
                'description' => '',
                'parent_id' => null,
                'active' => 1,
                'created_at' => '2025-09-11 18:08:30',
                'updated_at' => '2025-09-13 11:07:05',
                'deleted_at' => null,
            ],
            [
                'id' => 18,
                'name' => 'فرع حفرالباطن',
                'code' => '22222',
                'description' => '',
                'parent_id' => null,
                'active' => 1,
                'created_at' => '2025-09-13 11:06:51',
                'updated_at' => '2025-09-13 11:06:51',
                'deleted_at' => null,
            ],
            [
                'id' => 19,
                'name' => 'فرع عرعر',
                'code' => '33333',
                'description' => '',
                'parent_id' => null,
                'active' => 1,
                'created_at' => '2025-09-13 11:07:21',
                'updated_at' => '2025-09-13 11:07:21',
                'deleted_at' => null,
            ],
            [
                'id' => 20,
                'name' => 'عام',
                'code' => '44444',
                'description' => '',
                'parent_id' => null,
                'active' => 1,
                'created_at' => '2025-09-13 11:07:43',
                'updated_at' => '2025-09-13 11:07:43',
                'deleted_at' => null,
            ],
            [
                'id' => 21,
                'name' => 'الوكالات الرجالية',
                'code' => '55555',
                'description' => '',
                'parent_id' => null,
                'active' => 1,
                'created_at' => '2025-09-13 11:08:01',
                'updated_at' => '2025-09-13 11:08:01',
                'deleted_at' => null,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 100,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 8,
                'name' => 2,
            ],
            [
                'id' => 8,
                'name' => 2,
            ],
            [
                'id' => 8,
                'name' => 2,
            ],
            [
                'id' => 15,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => '`id` int(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 500,
            ],
            [
                'id' => 'json_valid(`img`',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 8,
                'name' => 2,
            ],
        ];

        foreach ($data as $row) {
            DB::table('cost_centers')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
