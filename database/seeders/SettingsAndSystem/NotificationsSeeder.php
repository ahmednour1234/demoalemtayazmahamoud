<?php

namespace Database\Seeders\SettingsAndSystem;

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
        DB::statement('INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `body`, `data`, `read_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 159, \'task.assigned\', \'تم إسناد مهمة جديدة\', \'عنوان المهمة: gfgf\', \'{\\"task_id\\":1,\\"assigned_by\\":100}\', NULL, NULL, \'2025-09-07 21:49:06\', \'2025-09-07 21:49:06\'),
(2, 160, \'task.assigned\', \'تم إسناد مهمة جديدة\', \'عنوان المهمة: gfgf\', \'{\\"task_id\\":1,\\"assigned_by\\":100}\', NULL, NULL, \'2025-09-07 21:49:06\', \'2025-09-07 21:49:06\'),
(3, 161, \'task.assigned\', \'تم إسناد مهمة جديدة\', \'عنوان المهمة: gfgf\', \'{\\"task_id\\":1,\\"assigned_by\\":100}\', NULL, NULL, \'2025-09-07 21:49:06\', \'2025-09-07 21:49:06\'),
(4, 162, \'task.assigned\', \'تم إسناد مهمة جديدة\', \'عنوان المهمة: gfgf\', \'{\\"task_id\\":1,\\"assigned_by\\":100}\', NULL, NULL, \'2025-09-07 21:49:06\', \'2025-09-07 21:49:06\'),
(5, 100, \'approval.request\', \'طلب موافقة جديد\', \'طلب موافقة على task #1\', \'{\\"type\\":\\"task\\",\\"id\\":1,\\"requested_by\\":100}\', NULL, NULL, \'2025-09-07 21:49:06\', \'2025-09-07 21:49:06\'),
(6, 159, \'task.assigned\', \'تم إسناد مهمة جديدة\', \'عنوان المهمة: sfdsfsd\', \'{\\"task_id\\":2,\\"assigned_by\\":100}\', NULL, NULL, \'2025-09-07 22:39:30\', \'2025-09-07 22:39:30\'),
(7, 160, \'task.assigned\', \'تم إسناد مهمة جديدة\', \'عنوان المهمة: sfdsfsd\', \'{\\"task_id\\":2,\\"assigned_by\\":100}\', NULL, NULL, \'2025-09-07 22:39:30\', \'2025-09-07 22:39:30\'),
(8, 161, \'task.assigned\', \'تم إسناد مهمة جديدة\', \'عنوان المهمة: sfdsfsd\', \'{\\"task_id\\":2,\\"assigned_by\\":100}\', NULL, NULL, \'2025-09-07 22:39:30\', \'2025-09-07 22:39:30\'),
(9, 162, \'task.assigned\', \'تم إسناد مهمة جديدة\', \'عنوان المهمة: sfdsfsd\', \'{\\"task_id\\":2,\\"assigned_by\\":100}\', NULL, NULL, \'2025-09-07 22:39:30\', \'2025-09-07 22:39:30\'),
(10, 159, \'comment.task\', \'تعليق جديد على مهمة\', \'wwqewq\', \'{\\"entity_type\\":\\"task\\",\\"entity_id\\":2,\\"comment_id\\":1}\', NULL, NULL, \'2025-09-07 23:07:24\', \'2025-09-07 23:07:24\'),
(11, 160, \'comment.task\', \'تعليق جديد على مهمة\', \'wwqewq\', \'{\\"entity_type\\":\\"task\\",\\"entity_id\\":2,\\"comment_id\\":1}\', NULL, NULL, \'2025-09-07 23:07:24\', \'2025-09-07 23:07:24\'),
(12, 161, \'comment.task\', \'تعليق جديد على مهمة\', \'wwqewq\', \'{\\"entity_type\\":\\"task\\",\\"entity_id\\":2,\\"comment_id\\":1}\', NULL, NULL, \'2025-09-07 23:07:24\', \'2025-09-07 23:07:24\'),
(13, 162, \'comment.task\', \'تعليق جديد على مهمة\', \'wwqewq\', \'{\\"entity_type\\":\\"task\\",\\"entity_id\\":2,\\"comment_id\\":1}\', NULL, NULL, \'2025-09-07 23:07:24\', \'2025-09-07 23:07:24\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
