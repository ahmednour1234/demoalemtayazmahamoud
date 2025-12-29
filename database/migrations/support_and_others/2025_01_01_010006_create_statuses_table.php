<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `statuses`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `statuses` -- CREATE TABLE `statuses` ( `id` bigint(20) UNSIGNED NOT NULL, `name` varchar(191) NOT NULL, `code` varchar(64) NOT NULL, `color` varchar(32) DEFAULT NULL, `sort_order` int(11) NOT NULL DEFAULT 0, `active` tinyint(1) NOT NULL DEFAULT 1, `deleted_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `statuses` -- ALTER TABLE `statuses` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code` (`code`), ADD KEY `idx_statuses_active` (`active`), ADD KEY `idx_statuses_sort` (`sort_order`), ADD KEY `idx_statuses_name` (`name`);");
        DB::statement("-- -- AUTO_INCREMENT for table `statuses` -- ALTER TABLE `statuses` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
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
        Schema::dropIfExists('statuses');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
