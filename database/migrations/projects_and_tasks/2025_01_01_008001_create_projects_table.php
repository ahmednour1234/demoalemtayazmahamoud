<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `projects`");
        DB::statement("CREATE TABLE `projects` ( `id` bigint(20) UNSIGNED NOT NULL, `name` varchar(191) NOT NULL, `code` varchar(64) NOT NULL, `description` text DEFAULT NULL, `status_id` bigint(20) UNSIGNED DEFAULT NULL, `owner_id` bigint(20) UNSIGNED NOT NULL, `lead_id` bigint(20) UNSIGNED DEFAULT NULL, `priority` enum('low','medium','high','urgent') DEFAULT 'medium', `start_date` date DEFAULT NULL, `due_date` date DEFAULT NULL, `active` tinyint(1) NOT NULL DEFAULT 1, `deleted_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `projects` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code` (`code`), ADD KEY `idx_projects_status` (`status_id`), ADD KEY `idx_projects_owner` (`owner_id`), ADD KEY `idx_projects_lead` (`lead_id`), ADD KEY `idx_projects_dates` (`start_date`,`due_date`), ADD KEY `idx_projects_active` (`active`), ADD KEY `idx_projects_code_name` (`code`,`name`);");
        DB::statement("ALTER TABLE `projects` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;");
        DB::statement("ALTER TABLE `projects` ADD CONSTRAINT `fk_projects_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`), ADD CONSTRAINT `fk_projects_owner` FOREIGN KEY (`owner_id`) REFERENCES `admins` (`id`);");
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
        Schema::dropIfExists('projects');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
