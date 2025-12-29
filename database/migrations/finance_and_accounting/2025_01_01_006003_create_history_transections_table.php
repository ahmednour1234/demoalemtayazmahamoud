<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHistoryTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `history_transections`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `history_transections` -- CREATE TABLE `history_transections` ( `id` bigint(20) UNSIGNED NOT NULL, `tran_type` varchar(255) DEFAULT NULL, `account_id` bigint(20) UNSIGNED DEFAULT NULL, `seller_id` bigint(20) UNSIGNED DEFAULT NULL, `amount` double DEFAULT NULL, `description` varchar(255) DEFAULT NULL, `debit` tinyint(1) DEFAULT NULL, `credit` tinyint(1) DEFAULT NULL, `balance` double DEFAULT 0, `date` date DEFAULT NULL, `customer_id` int(10) UNSIGNED DEFAULT NULL, `supplier_id` int(10) UNSIGNED DEFAULT NULL, `order_id` int(10) UNSIGNED DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT NULL, `img` mediumtext DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `history_transections` -- ALTER TABLE `history_transections` ADD PRIMARY KEY (`id`), ADD KEY `seller_id` (`seller_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `history_transections` -- ALTER TABLE `history_transections` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('history_transections');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
