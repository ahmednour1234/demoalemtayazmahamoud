<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `tickets`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `tickets` -- CREATE TABLE `tickets` ( `id` bigint(20) UNSIGNED NOT NULL, `code` varchar(50) DEFAULT NULL, `title` varchar(255) NOT NULL, `description` text DEFAULT NULL, `approved_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending', `approved_by` bigint(20) UNSIGNED DEFAULT NULL, `approved_at` datetime DEFAULT NULL, `is_resolved` tinyint(1) NOT NULL DEFAULT 0, `resolved_by` bigint(20) UNSIGNED DEFAULT NULL, `resolved_at` datetime DEFAULT NULL, `created_by` bigint(20) UNSIGNED DEFAULT NULL, `created_at` datetime NOT NULL DEFAULT current_timestamp(), `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `tickets` -- ALTER TABLE `tickets` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code` (`code`), ADD KEY `idx_approved_status` (`approved_status`), ADD KEY `idx_is_resolved` (`is_resolved`), ADD KEY `idx_created_by` (`created_by`), ADD KEY `idx_resolved_by` (`resolved_by`), ADD KEY `idx_approved_by` (`approved_by`);");
        DB::statement("-- -- AUTO_INCREMENT for table `tickets` -- ALTER TABLE `tickets` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('tickets');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
