<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLeadTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `lead_tasks`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `lead_tasks` -- CREATE TABLE `lead_tasks` ( `id` bigint(20) UNSIGNED NOT NULL, `lead_id` bigint(20) UNSIGNED NOT NULL, `title` varchar(190) NOT NULL, `due_at` datetime DEFAULT NULL, `assigned_to_id` bigint(20) UNSIGNED DEFAULT NULL, `status` enum('pending','done','canceled') NOT NULL DEFAULT 'pending', `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal', `created_by_id` bigint(20) UNSIGNED DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        DB::statement("-- -- Indexes for table `lead_tasks` -- ALTER TABLE `lead_tasks` ADD PRIMARY KEY (`id`), ADD KEY `idx_tasks_lead` (`lead_id`), ADD KEY `idx_tasks_due` (`due_at`), ADD KEY `idx_tasks_assg` (`assigned_to_id`), ADD KEY `fk_tasks_crby` (`created_by_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `lead_tasks` -- ALTER TABLE `lead_tasks` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("-- -- Constraints for table `lead_tasks` -- ALTER TABLE `lead_tasks` ADD CONSTRAINT `fk_tasks_assg` FOREIGN KEY (`assigned_to_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL, ADD CONSTRAINT `fk_tasks_crby` FOREIGN KEY (`created_by_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL, ADD CONSTRAINT `fk_tasks_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('lead_tasks');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
