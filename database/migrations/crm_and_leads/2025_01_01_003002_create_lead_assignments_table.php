<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLeadAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `lead_assignments`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `lead_assignments` -- CREATE TABLE `lead_assignments` ( `id` bigint(20) UNSIGNED NOT NULL, `lead_id` bigint(20) UNSIGNED NOT NULL, `assigned_to_admin_id` bigint(20) UNSIGNED NOT NULL, `assigned_by_admin_id` bigint(20) UNSIGNED DEFAULT NULL, `assigned_at` datetime NOT NULL, `reason` varchar(190) DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        DB::statement("-- -- Indexes for table `lead_assignments` -- ALTER TABLE `lead_assignments` ADD PRIMARY KEY (`id`), ADD KEY `idx_la_lead` (`lead_id`), ADD KEY `idx_la_to` (`assigned_to_admin_id`), ADD KEY `idx_la_by` (`assigned_by_admin_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `lead_assignments` -- ALTER TABLE `lead_assignments` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("-- -- Constraints for table `lead_assignments` -- ALTER TABLE `lead_assignments` ADD CONSTRAINT `fk_la_by` FOREIGN KEY (`assigned_by_admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL, ADD CONSTRAINT `fk_la_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE, ADD CONSTRAINT `fk_la_to` FOREIGN KEY (`assigned_to_admin_id`) REFERENCES `admins` (`id`);");
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
        Schema::dropIfExists('lead_assignments');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
