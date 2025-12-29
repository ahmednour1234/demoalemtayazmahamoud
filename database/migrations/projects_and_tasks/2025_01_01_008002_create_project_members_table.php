<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProjectMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `project_members`");
        DB::statement("CREATE TABLE `project_members` ( `id` bigint(20) UNSIGNED NOT NULL, `project_id` bigint(20) UNSIGNED NOT NULL, `admin_id` bigint(20) UNSIGNED NOT NULL, `role` enum('owner','leader','member','viewer') NOT NULL DEFAULT 'member', `added_by` bigint(20) UNSIGNED DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `project_members` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uq_pm_unique` (`project_id`,`admin_id`), ADD KEY `fk_pm_admin` (`admin_id`), ADD KEY `fk_pm_added` (`added_by`), ADD KEY `idx_pm_role` (`role`);");
        DB::statement("ALTER TABLE `project_members` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;");
        DB::statement("ALTER TABLE `project_members` ADD CONSTRAINT `fk_pm_added` FOREIGN KEY (`added_by`) REFERENCES `admins` (`id`), ADD CONSTRAINT `fk_pm_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`), ADD CONSTRAINT `fk_pm_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('project_members');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
