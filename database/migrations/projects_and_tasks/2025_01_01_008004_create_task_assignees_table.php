<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTaskAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `task_assignees`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `task_assignees` -- CREATE TABLE `task_assignees` ( `id` bigint(20) UNSIGNED NOT NULL, `task_id` bigint(20) UNSIGNED NOT NULL, `admin_id` bigint(20) UNSIGNED NOT NULL, `role` enum('assignee','reviewer','watcher') NOT NULL DEFAULT 'assignee', `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium', `due_at` datetime DEFAULT NULL, `assigned_by` bigint(20) UNSIGNED DEFAULT NULL, `assigned_at` datetime DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `task_assignees` -- ALTER TABLE `task_assignees` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uq_ta_unique` (`task_id`,`admin_id`,`role`), ADD KEY `fk_ta_admin` (`admin_id`), ADD KEY `fk_ta_by` (`assigned_by`), ADD KEY `idx_ta_due` (`due_at`), ADD KEY `idx_ta_role` (`role`), ADD KEY `idx_ta_priority` (`priority`);");
        DB::statement("-- -- AUTO_INCREMENT for table `task_assignees` -- ALTER TABLE `task_assignees` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;");
        DB::statement("-- -- Constraints for table `task_assignees` -- ALTER TABLE `task_assignees` ADD CONSTRAINT `fk_ta_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`), ADD CONSTRAINT `fk_ta_by` FOREIGN KEY (`assigned_by`) REFERENCES `admins` (`id`), ADD CONSTRAINT `fk_ta_task` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('task_assignees');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
