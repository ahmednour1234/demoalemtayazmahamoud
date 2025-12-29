<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `system_logs`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `system_logs` -- CREATE TABLE `system_logs` ( `id` bigint(20) UNSIGNED NOT NULL, `actor_admin_id` bigint(20) UNSIGNED DEFAULT NULL, `action` varchar(100) NOT NULL, `table_name` varchar(100) DEFAULT NULL, `record_id` bigint(20) UNSIGNED DEFAULT NULL, `lead_id` bigint(20) UNSIGNED DEFAULT NULL, `ip_address` varchar(45) DEFAULT NULL, `user_agent` varchar(255) DEFAULT NULL, `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)), `created_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        DB::statement("-- -- Indexes for table `system_logs` -- ALTER TABLE `system_logs` ADD PRIMARY KEY (`id`), ADD KEY `idx_logs_actor` (`actor_admin_id`), ADD KEY `idx_logs_lead` (`lead_id`), ADD KEY `idx_logs_table` (`table_name`,`record_id`), ADD KEY `idx_logs_action` (`action`);");
        DB::statement("-- -- AUTO_INCREMENT for table `system_logs` -- ALTER TABLE `system_logs` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;");
        DB::statement("-- -- Constraints for table `system_logs` -- ALTER TABLE `system_logs` ADD CONSTRAINT `fk_logs_actor` FOREIGN KEY (`actor_admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL, ADD CONSTRAINT `fk_logs_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL;");
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
        Schema::dropIfExists('system_logs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
