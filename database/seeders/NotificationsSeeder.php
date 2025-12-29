<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('notifications')->truncate();

        $data = [
            [
                'id' => 1,
                'user_id' => 159,
                'type' => 'task.assigned',
                'title' => 'تم إسناد مهمة جديدة',
                'body' => 'عنوان المهمة: gfgf',
                'data' => '{\"task_id\":1,\"assigned_by\":100}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 21:49:06',
            ],
            [
                'id' => 2,
                'user_id' => 160,
                'type' => 'task.assigned',
                'title' => 'تم إسناد مهمة جديدة',
                'body' => 'عنوان المهمة: gfgf',
                'data' => '{\"task_id\":1,\"assigned_by\":100}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 21:49:06',
            ],
            [
                'id' => 3,
                'user_id' => 161,
                'type' => 'task.assigned',
                'title' => 'تم إسناد مهمة جديدة',
                'body' => 'عنوان المهمة: gfgf',
                'data' => '{\"task_id\":1,\"assigned_by\":100}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 21:49:06',
            ],
            [
                'id' => 4,
                'user_id' => 162,
                'type' => 'task.assigned',
                'title' => 'تم إسناد مهمة جديدة',
                'body' => 'عنوان المهمة: gfgf',
                'data' => '{\"task_id\":1,\"assigned_by\":100}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 21:49:06',
            ],
            [
                'id' => 5,
                'user_id' => 100,
                'type' => 'approval.request',
                'title' => 'طلب موافقة جديد',
                'body' => 'طلب موافقة على task #1',
                'data' => '{\"type\":\"task\",\"id\":1,\"requested_by\":100}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 21:49:06',
                'updated_at' => '2025-09-07 21:49:06',
            ],
            [
                'id' => 6,
                'user_id' => 159,
                'type' => 'task.assigned',
                'title' => 'تم إسناد مهمة جديدة',
                'body' => 'عنوان المهمة: sfdsfsd',
                'data' => '{\"task_id\":2,\"assigned_by\":100}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:39:30',
                'updated_at' => '2025-09-07 22:39:30',
            ],
            [
                'id' => 7,
                'user_id' => 160,
                'type' => 'task.assigned',
                'title' => 'تم إسناد مهمة جديدة',
                'body' => 'عنوان المهمة: sfdsfsd',
                'data' => '{\"task_id\":2,\"assigned_by\":100}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:39:30',
                'updated_at' => '2025-09-07 22:39:30',
            ],
            [
                'id' => 8,
                'user_id' => 161,
                'type' => 'task.assigned',
                'title' => 'تم إسناد مهمة جديدة',
                'body' => 'عنوان المهمة: sfdsfsd',
                'data' => '{\"task_id\":2,\"assigned_by\":100}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:39:30',
                'updated_at' => '2025-09-07 22:39:30',
            ],
            [
                'id' => 9,
                'user_id' => 162,
                'type' => 'task.assigned',
                'title' => 'تم إسناد مهمة جديدة',
                'body' => 'عنوان المهمة: sfdsfsd',
                'data' => '{\"task_id\":2,\"assigned_by\":100}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 22:39:30',
                'updated_at' => '2025-09-07 22:39:30',
            ],
            [
                'id' => 10,
                'user_id' => 159,
                'type' => 'comment.task',
                'title' => 'تعليق جديد على مهمة',
                'body' => 'wwqewq',
                'data' => '{\"entity_type\":\"task\",\"entity_id\":2,\"comment_id\":1}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 23:07:24',
                'updated_at' => '2025-09-07 23:07:24',
            ],
            [
                'id' => 11,
                'user_id' => 160,
                'type' => 'comment.task',
                'title' => 'تعليق جديد على مهمة',
                'body' => 'wwqewq',
                'data' => '{\"entity_type\":\"task\",\"entity_id\":2,\"comment_id\":1}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 23:07:24',
                'updated_at' => '2025-09-07 23:07:24',
            ],
            [
                'id' => 12,
                'user_id' => 161,
                'type' => 'comment.task',
                'title' => 'تعليق جديد على مهمة',
                'body' => 'wwqewq',
                'data' => '{\"entity_type\":\"task\",\"entity_id\":2,\"comment_id\":1}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 23:07:24',
                'updated_at' => '2025-09-07 23:07:24',
            ],
            [
                'id' => 13,
                'user_id' => 162,
                'type' => 'comment.task',
                'title' => 'تعليق جديد على مهمة',
                'body' => 'wwqewq',
                'data' => '{\"entity_type\":\"task\",\"entity_id\":2,\"comment_id\":1}',
                'read_at' => null,
                'deleted_at' => null,
                'created_at' => '2025-09-07 23:07:24',
                'updated_at' => '2025-09-07 23:07:24',
            ],
            [
                'id' => '`id` varchar(100',
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
        ];

        foreach ($data as $row) {
            DB::table('notifications')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
