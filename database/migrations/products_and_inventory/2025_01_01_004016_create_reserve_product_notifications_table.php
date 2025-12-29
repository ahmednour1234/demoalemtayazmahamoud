<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateReserveProductNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `reserve_product_notifications`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `reserve_product_notifications` -- CREATE TABLE `reserve_product_notifications` ( `id` bigint(20) UNSIGNED NOT NULL, `data` text NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `customer_id` bigint(20) UNSIGNED NOT NULL, `date` varchar(200) DEFAULT NULL, `type` varchar(255) DEFAULT NULL, `active` int(11) NOT NULL DEFAULT 0, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `insert_flag` int(11) NOT NULL DEFAULT 1, `update_flag` int(11) NOT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `reserve_product_notifications` -- ALTER TABLE `reserve_product_notifications` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `reserve_product_notifications` -- ALTER TABLE `reserve_product_notifications` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('reserve_product_notifications');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
