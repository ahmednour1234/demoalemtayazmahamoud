<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tasks')->truncate();

        $data = [
            [
                'id' => 1,
                'project_id' => 1,
                'lead_id' => null,
                'title' => 'gfgf',
                'description' => 'dfdfd',
                'status_id' => 1,
                'priority' => 'medium',
                'start_at' => '2025-08-31 21:48:00',
                'due_at' => '2025-10-11 21:48:00',
                'estimated_minutes' => 5000,
                'actual_minutes' => null,
                'created_by' => 100,
                'approval_required' => 1,
                'approval_status' => 'rejected',
                'approved_by' => 100,
                'approved_at' => '2025-09-07 22:26:35',
                'rejection_reason' => 'qde',
                'next_step_hint' => 'weqq',
                'deleted_at' => '2025-09-07 22:39:01',
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 22:39:01',
            ],
            [
                'id' => 2,
                'project_id' => 1,
                'lead_id' => null,
                'title' => 'sfdsfsd',
                'description' => 'dsfdsf',
                'status_id' => 1,
                'priority' => 'medium',
                'start_at' => '2025-09-09 22:39:00',
                'due_at' => '2025-10-06 22:39:00',
                'estimated_minutes' => 2332,
                'actual_minutes' => null,
                'created_by' => 100,
                'approval_required' => 0,
                'approval_status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'rejection_reason' => null,
                'next_step_hint' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:39:30',
                'updated_at' => '2025-09-07 19:54:39',
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
                'id' => 'assignee',
                'project_id' => 'reviewer',
                'lead_id' => 'watcher',
            ],
            [
                'id' => 'low',
                'project_id' => 'medium',
                'lead_id' => 'high',
                'title' => 'urgent',
            ],
            [
                'id' => 20,
            ],
        ];

        foreach ($data as $row) {
            DB::table('tasks')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
