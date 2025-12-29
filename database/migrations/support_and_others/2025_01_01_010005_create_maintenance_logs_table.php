<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMaintenanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `maintenance_logs`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `maintenance_logs` -- CREATE TABLE `maintenance_logs` ( `id` bigint(20) UNSIGNED NOT NULL, `asset_id` bigint(20) UNSIGNED NOT NULL, `maintenance_date` date NOT NULL, `maintenance_type` enum('preventive','emergency') NOT NULL, `estimated_cost` decimal(12,2) DEFAULT NULL, `notes` text DEFAULT NULL, `status` enum('scheduled','in progress','completed') NOT NULL DEFAULT 'scheduled', `branch_id` bigint(20) NOT NULL DEFAULT 1, `added_by` bigint(20) DEFAULT NULL, `approved_by` bigint(20) DEFAULT NULL, `done_by` bigint(20) DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `maintenance_logs` -- ALTER TABLE `maintenance_logs` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `maintenance_logs` -- ALTER TABLE `maintenance_logs` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('maintenance_logs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
