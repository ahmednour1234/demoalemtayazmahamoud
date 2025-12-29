<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('projects')->truncate();

        $data = [
            [
                'id' => 1,
                'name' => 'مدير',
                'code' => '09961',
                'description' => 'dfsdfsd',
                'status_id' => 1,
                'owner_id' => 100,
                'lead_id' => null,
                'priority' => 'medium',
                'start_date' => null,
                'due_date' => null,
                'active' => 1,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:38:26',
                'updated_at' => '2025-09-07 21:45:12',
            ],
            [
                'id' => 2,
                'name' => 'ضريبة صفريه',
                'code' => '13123',
                'description' => 'sdsfasddsa',
                'status_id' => 1,
                'owner_id' => 100,
                'lead_id' => null,
                'priority' => 'medium',
                'start_date' => '2025-09-01',
                'due_date' => '2025-10-10',
                'active' => 1,
                'deleted_at' => null,
                'created_at' => '2025-09-09 10:24:28',
                'updated_at' => '2025-09-09 10:24:28',
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
                'id' => 'owner',
                'name' => 'leader',
                'code' => 'member',
                'description' => 'viewer',
            ],
            [
                'id' => 20,
            ],
        ];

        foreach ($data as $row) {
            DB::table('projects')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
