<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('project_members')->truncate();

        $data = [
            [
                'id' => 1,
                'project_id' => 1,
                'admin_id' => 159,
                'role' => 'member',
                'added_by' => 100,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:47:25',
                'updated_at' => '2025-09-07 21:47:25',
            ],
            [
                'id' => 2,
                'project_id' => 1,
                'admin_id' => 160,
                'role' => 'member',
                'added_by' => 100,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:47:32',
                'updated_at' => '2025-09-07 21:47:32',
            ],
            [
                'id' => 3,
                'project_id' => 1,
                'admin_id' => 100,
                'role' => 'member',
                'added_by' => 100,
                'deleted_at' => '2025-09-07 21:47:52',
                'created_at' => '2025-09-07 21:47:36',
                'updated_at' => '2025-09-07 21:47:52',
            ],
            [
                'id' => 4,
                'project_id' => 1,
                'admin_id' => 162,
                'role' => 'leader',
                'added_by' => 100,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:47:41',
                'updated_at' => '2025-09-07 21:47:41',
            ],
            [
                'id' => 5,
                'project_id' => 1,
                'admin_id' => 161,
                'role' => 'member',
                'added_by' => 100,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:48:00',
                'updated_at' => '2025-09-07 21:48:00',
            ],
            [
                'id' => 7,
                'project_id' => 2,
                'admin_id' => 160,
                'role' => 'member',
                'added_by' => 100,
                'deleted_at' => null,
                'created_at' => '2025-09-09 10:24:41',
                'updated_at' => '2025-09-09 10:24:41',
            ],
            [
                'id' => 8,
                'project_id' => 2,
                'admin_id' => 159,
                'role' => 'member',
                'added_by' => 100,
                'deleted_at' => null,
                'created_at' => '2025-09-09 10:24:46',
                'updated_at' => '2025-09-09 10:24:46',
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
                'id' => 20,
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
                'id' => 10,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 222,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 255,
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
                'id' => 6555,
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
                'id' => 11,
            ],
            [
                'id' => 11,
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
                'id' => 255,
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
            DB::table('project_members')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
