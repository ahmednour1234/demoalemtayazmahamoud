<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `tasks`");
        DB::statement("CREATE TABLE `tasks` ( `id` bigint(20) UNSIGNED NOT NULL, `project_id` bigint(20) UNSIGNED DEFAULT NULL, `lead_id` bigint(20) UNSIGNED DEFAULT NULL, `title` varchar(191) NOT NULL, `description` text DEFAULT NULL, `status_id` bigint(20) UNSIGNED DEFAULT NULL, `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium', `start_at` datetime DEFAULT NULL, `due_at` datetime DEFAULT NULL, `estimated_minutes` int(10) UNSIGNED DEFAULT NULL, `actual_minutes` int(10) UNSIGNED DEFAULT NULL, `created_by` bigint(20) UNSIGNED NOT NULL, `approval_required` tinyint(1) NOT NULL DEFAULT 0, `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending', `approved_by` bigint(20) UNSIGNED DEFAULT NULL, `approved_at` datetime DEFAULT NULL, `rejection_reason` varchar(255) DEFAULT NULL, `next_step_hint` varchar(255) DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `tasks` ADD PRIMARY KEY (`id`), ADD KEY `idx_tasks_project` (`project_id`), ADD KEY `idx_tasks_lead` (`lead_id`), ADD KEY `idx_tasks_priority` (`priority`), ADD KEY `idx_tasks_due` (`due_at`), ADD KEY `idx_tasks_approval` (`approval_required`,`approval_status`);");
        DB::statement("ALTER TABLE `tasks` ADD FULLTEXT KEY `ft_tasks_txt` (`title`,`description`);");
        DB::statement("ALTER TABLE `tasks` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;");
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
        Schema::dropIfExists('tasks');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
