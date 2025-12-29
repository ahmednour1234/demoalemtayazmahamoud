<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowUpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('follow_ups')->truncate();

        $data = [
            [
                'id' => 1,
                'task_id' => 2,
                'project_id' => null,
                'lead_id' => null,
                'created_by' => 100,
                'assigned_to' => null,
                'next_follow_up_at' => '2025-09-18 22:35:00',
                'status' => 'done',
                'comment' => 'jbjnun',
                'lost_at' => null,
                'lost_reason' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:36:04',
                'updated_at' => '2025-09-07 23:14:32',
            ],
            [
                'id' => 2,
                'task_id' => 1,
                'project_id' => null,
                'lead_id' => null,
                'created_by' => 100,
                'assigned_to' => null,
                'next_follow_up_at' => '2025-09-18 22:35:00',
                'status' => 'scheduled',
                'comment' => 'jbjnun',
                'lost_at' => null,
                'lost_reason' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:36:24',
                'updated_at' => '2025-09-07 19:50:36',
            ],
            [
                'id' => 3,
                'task_id' => null,
                'project_id' => null,
                'lead_id' => null,
                'created_by' => 100,
                'assigned_to' => null,
                'next_follow_up_at' => '2025-10-01 22:38:00',
                'status' => 'scheduled',
                'comment' => 'jbjnun',
                'lost_at' => null,
                'lost_reason' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:38:27',
                'updated_at' => '2025-09-07 22:38:27',
            ],
            [
                'id' => 4,
                'task_id' => null,
                'project_id' => null,
                'lead_id' => null,
                'created_by' => 100,
                'assigned_to' => null,
                'next_follow_up_at' => '2025-10-01 22:38:00',
                'status' => 'scheduled',
                'comment' => 'jbjnun',
                'lost_at' => null,
                'lost_reason' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:38:41',
                'updated_at' => '2025-09-07 22:38:41',
            ],
            [
                'id' => 5,
                'task_id' => null,
                'project_id' => null,
                'lead_id' => null,
                'created_by' => 100,
                'assigned_to' => null,
                'next_follow_up_at' => '2025-09-02 22:41:00',
                'status' => 'scheduled',
                'comment' => 'jbjnun',
                'lost_at' => null,
                'lost_reason' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:41:14',
                'updated_at' => '2025-09-07 22:41:14',
            ],
            [
                'id' => 6,
                'task_id' => null,
                'project_id' => null,
                'lead_id' => null,
                'created_by' => 100,
                'assigned_to' => null,
                'next_follow_up_at' => '2025-09-06 22:49:00',
                'status' => 'scheduled',
                'comment' => 'jbjnun',
                'lost_at' => null,
                'lost_reason' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:50:00',
                'updated_at' => '2025-09-07 22:50:00',
            ],
            [
                'id' => 7,
                'task_id' => 2,
                'project_id' => null,
                'lead_id' => null,
                'created_by' => 100,
                'assigned_to' => null,
                'next_follow_up_at' => '2025-09-09 10:27:00',
                'status' => 'done',
                'comment' => 'ddd',
                'lost_at' => null,
                'lost_reason' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-09 10:27:48',
                'updated_at' => '2025-09-09 10:32:07',
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
                'id' => 255,
            ],
            [
                'id' => 10,
                'task_id' => 2,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 'json_valid(`images`',
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
                'id' => 20,
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
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 255,
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
                'id' => 1,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
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
                'id' => 11,
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
                'id' => 12,
                'task_id' => 2,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 5,
                'task_id' => 2,
            ],
            [
                'id' => 'active',
                'task_id' => 'completed',
                'project_id' => 'cancelled',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => '`id` int(11',
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
                'id' => '`id` int(10',
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 50,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => '`id` int(10',
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
                'task_id' => 2,
            ],
            [
                'id' => 10,
                'task_id' => 2,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => '`id` int(10',
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 50,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => '`id` int(10',
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
                'task_id' => 2,
            ],
            [
                'id' => 10,
                'task_id' => 2,
            ],
            [
                'id' => 10,
                'task_id' => 2,
            ],
            [
                'id' => '`counted_quantity` - `system_quantity`',
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
                'id' => 50,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 'new',
                'task_id' => 'screening',
                'project_id' => 'interview',
                'lead_id' => 'accepted',
                'created_by' => 'rejected',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 100,
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
                'id' => 20,
            ],
        ];

        foreach ($data as $row) {
            DB::table('follow_ups')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
