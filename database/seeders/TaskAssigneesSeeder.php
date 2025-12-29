<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskAssigneesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('task_assignees')->truncate();

        $data = [
            [
                'id' => 1,
                'task_id' => 1,
                'admin_id' => 159,
                'role' => 'assignee',
                'priority' => 'medium',
                'due_at' => '2025-10-11 21:48:00',
                'assigned_by' => 100,
                'assigned_at' => '2025-09-07 18:49:06',
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 21:49:06',
            ],
            [
                'id' => 2,
                'task_id' => 1,
                'admin_id' => 160,
                'role' => 'assignee',
                'priority' => 'medium',
                'due_at' => '2025-10-11 21:48:00',
                'assigned_by' => 100,
                'assigned_at' => '2025-09-07 18:49:06',
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 21:49:06',
            ],
            [
                'id' => 3,
                'task_id' => 1,
                'admin_id' => 161,
                'role' => 'assignee',
                'priority' => 'medium',
                'due_at' => '2025-10-11 21:48:00',
                'assigned_by' => 100,
                'assigned_at' => '2025-09-07 18:49:06',
                'deleted_at' => '2025-09-07 22:19:29',
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 22:19:29',
            ],
            [
                'id' => 4,
                'task_id' => 1,
                'admin_id' => 162,
                'role' => 'assignee',
                'priority' => 'medium',
                'due_at' => '2025-10-11 21:48:00',
                'assigned_by' => 100,
                'assigned_at' => '2025-09-07 18:49:06',
                'deleted_at' => '2025-09-07 22:19:26',
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 22:19:26',
            ],
            [
                'id' => 5,
                'task_id' => 1,
                'admin_id' => 159,
                'role' => 'reviewer',
                'priority' => 'urgent',
                'due_at' => '2025-09-25 22:19:00',
                'assigned_by' => 100,
                'assigned_at' => '2025-09-07 19:19:20',
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:19:20',
                'updated_at' => '2025-09-07 22:19:20',
            ],
            [
                'id' => 6,
                'task_id' => 2,
                'admin_id' => 159,
                'role' => 'assignee',
                'priority' => 'medium',
                'due_at' => '2025-10-06 22:39:00',
                'assigned_by' => 100,
                'assigned_at' => '2025-09-07 19:39:30',
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:39:30',
                'updated_at' => '2025-09-07 22:39:30',
            ],
            [
                'id' => 7,
                'task_id' => 2,
                'admin_id' => 160,
                'role' => 'assignee',
                'priority' => 'medium',
                'due_at' => '2025-10-06 22:39:00',
                'assigned_by' => 100,
                'assigned_at' => '2025-09-07 19:39:30',
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:39:30',
                'updated_at' => '2025-09-07 22:39:30',
            ],
            [
                'id' => 8,
                'task_id' => 2,
                'admin_id' => 161,
                'role' => 'assignee',
                'priority' => 'medium',
                'due_at' => '2025-10-06 22:39:00',
                'assigned_by' => 100,
                'assigned_at' => '2025-09-07 19:39:30',
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:39:30',
                'updated_at' => '2025-09-07 22:39:30',
            ],
            [
                'id' => 9,
                'task_id' => 2,
                'admin_id' => 162,
                'role' => 'assignee',
                'priority' => 'medium',
                'due_at' => '2025-10-06 22:39:00',
                'assigned_by' => 100,
                'assigned_at' => '2025-09-07 19:39:30',
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:39:30',
                'updated_at' => '2025-09-07 22:39:30',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 25,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
        ];

        foreach ($data as $row) {
            DB::table('task_assignees')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
