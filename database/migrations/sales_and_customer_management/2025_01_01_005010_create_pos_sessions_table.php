<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePosSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `pos_sessions`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `pos_sessions` -- CREATE TABLE `pos_sessions` ( `id` bigint(20) UNSIGNED NOT NULL, `user_id` bigint(20) UNSIGNED NOT NULL, `branch_id` bigint(20) UNSIGNED DEFAULT NULL, `start_time` datetime NOT NULL, `end_time` datetime DEFAULT NULL, `total_cash` decimal(12,2) DEFAULT 0.00, `total_card` decimal(12,2) DEFAULT 0.00, `total_discount` decimal(12,2) DEFAULT 0.00, `total_orders` int(11) DEFAULT 0, `total_returns` int(11) NOT NULL DEFAULT 0, `total_amount_returns` double NOT NULL DEFAULT 0, `status` enum('open','closed') DEFAULT 'open', `notes` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `pos_sessions` -- ALTER TABLE `pos_sessions` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `pos_sessions` -- ALTER TABLE `pos_sessions` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('pos_sessions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
