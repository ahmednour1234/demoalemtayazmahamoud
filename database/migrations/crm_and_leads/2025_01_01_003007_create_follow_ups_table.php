<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFollowUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `follow_ups`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `follow_ups` -- CREATE TABLE `follow_ups` ( `id` bigint(20) UNSIGNED NOT NULL, `task_id` bigint(20) UNSIGNED DEFAULT NULL, `project_id` bigint(20) UNSIGNED DEFAULT NULL, `lead_id` bigint(20) UNSIGNED DEFAULT NULL, `created_by` bigint(20) UNSIGNED NOT NULL, `assigned_to` bigint(20) UNSIGNED DEFAULT NULL, `next_follow_up_at` datetime NOT NULL, `status` enum('scheduled','done','skipped','lost') NOT NULL DEFAULT 'scheduled', `comment` text DEFAULT NULL, `lost_at` datetime DEFAULT NULL, `lost_reason` varchar(255) DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `follow_ups` -- ALTER TABLE `follow_ups` ADD PRIMARY KEY (`id`), ADD KEY `fk_fu_task` (`task_id`), ADD KEY `fk_fu_project` (`project_id`), ADD KEY `fk_fu_lead` (`lead_id`), ADD KEY `fk_fu_creator` (`created_by`), ADD KEY `idx_fu_next` (`next_follow_up_at`), ADD KEY `idx_fu_status` (`status`), ADD KEY `idx_fu_owner` (`assigned_to`);");
        DB::statement("-- -- AUTO_INCREMENT for table `follow_ups` -- ALTER TABLE `follow_ups` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;");
        DB::statement("-- -- Constraints for table `follow_ups` -- ALTER TABLE `follow_ups` ADD CONSTRAINT `fk_fu_creator` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`), ADD CONSTRAINT `fk_fu_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE, ADD CONSTRAINT `fk_fu_owner` FOREIGN KEY (`assigned_to`) REFERENCES `admins` (`id`), ADD CONSTRAINT `fk_fu_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE, ADD CONSTRAINT `fk_fu_task` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('follow_ups');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
