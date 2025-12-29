<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('departments')->truncate();

        $data = [
            [
                'id' => 1,
                'parent_id' => null,
                'name' => 'قسم المحاسبين',
                'code' => '999',
                'active' => 1,
                'level' => 0,
                'path' => '/1',
                'created_at' => '2025-09-07 16:05:08',
                'updated_at' => '2025-09-09 17:32:22',
                'deleted_at' => '2025-09-09 17:32:22',
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'name' => 'فريق محاسبين الرياض',
                'code' => '888',
                'active' => 1,
                'level' => 1,
                'path' => '/1/2',
                'created_at' => '2025-09-07 16:20:00',
                'updated_at' => '2025-09-09 17:32:25',
                'deleted_at' => '2025-09-09 17:32:25',
            ],
            [
                'id' => 3,
                'parent_id' => null,
                'name' => 'المحسابين',
                'code' => '1',
                'active' => 1,
                'level' => 0,
                'path' => '/3',
                'created_at' => '2025-09-09 17:32:53',
                'updated_at' => '2025-09-09 17:32:53',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'parent_id' => 3,
                'name' => 'محاسبين الرياض',
                'code' => '11',
                'active' => 1,
                'level' => 1,
                'path' => '/3/4',
                'created_at' => '2025-09-09 17:33:30',
                'updated_at' => '2025-09-09 17:33:30',
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'parent_id' => 3,
                'name' => 'محاسبين الحفر',
                'code' => '12',
                'active' => 1,
                'level' => 1,
                'path' => '/3/5',
                'created_at' => '2025-09-09 17:33:54',
                'updated_at' => '2025-09-09 17:33:54',
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'parent_id' => 3,
                'name' => 'محاسبين عرعر',
                'code' => '13',
                'active' => 1,
                'level' => 1,
                'path' => '/3/6',
                'created_at' => '2025-09-09 17:34:18',
                'updated_at' => '2025-09-09 17:34:18',
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'parent_id' => null,
                'name' => 'منسقين',
                'code' => '2',
                'active' => 1,
                'level' => 0,
                'path' => '/7',
                'created_at' => '2025-09-09 17:34:45',
                'updated_at' => '2025-09-09 17:34:45',
                'deleted_at' => null,
            ],
            [
                'id' => 8,
                'parent_id' => 7,
                'name' => 'منسقين الرياض',
                'code' => '21',
                'active' => 1,
                'level' => 1,
                'path' => '/7/8',
                'created_at' => '2025-09-09 17:35:01',
                'updated_at' => '2025-09-09 17:35:01',
                'deleted_at' => null,
            ],
            [
                'id' => 9,
                'parent_id' => 7,
                'name' => 'منسقين الحفر',
                'code' => '22',
                'active' => 1,
                'level' => 1,
                'path' => '/7/9',
                'created_at' => '2025-09-09 17:35:20',
                'updated_at' => '2025-09-09 17:35:20',
                'deleted_at' => null,
            ],
            [
                'id' => 10,
                'parent_id' => 7,
                'name' => 'منسقين عرعر',
                'code' => '23',
                'active' => 1,
                'level' => 1,
                'path' => '/7/10',
                'created_at' => '2025-09-09 17:35:34',
                'updated_at' => '2025-09-09 17:35:34',
                'deleted_at' => null,
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
                'id' => '`id` int(11',
            ],
            [
                'id' => 11,
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
                'id' => 255,
            ],
            [
                'id' => 15,
                'parent_id' => 2,
            ],
            [
                'id' => 255,
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
        ];

        foreach ($data as $row) {
            DB::table('departments')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
