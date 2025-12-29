<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrderNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `order_notifications`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `order_notifications` -- CREATE TABLE `order_notifications` ( `id` bigint(20) UNSIGNED NOT NULL, `user_id` bigint(20) UNSIGNED DEFAULT NULL, `stock_id` bigint(20) UNSIGNED DEFAULT NULL, `owner_id` bigint(20) UNSIGNED DEFAULT NULL, `owner_role` varchar(10) NOT NULL DEFAULT 'admin', `order_amount` double NOT NULL DEFAULT 0, `total_tax` double NOT NULL, `collected_cash` double DEFAULT NULL, `extra_discount` double DEFAULT NULL, `coupon_code` varchar(255) DEFAULT NULL, `coupon_discount_amount` double NOT NULL DEFAULT 0, `coupon_discount_title` varchar(255) DEFAULT NULL, `payment_id` bigint(20) UNSIGNED DEFAULT NULL, `transaction_reference` varchar(255) DEFAULT NULL, `insert_flag` int(11) NOT NULL DEFAULT 1, `update_flag` int(11) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `type` tinyint(1) NOT NULL DEFAULT 4, `active` int(11) NOT NULL DEFAULT 0, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `order_notifications` -- ALTER TABLE `order_notifications` ADD PRIMARY KEY (`id`), ADD KEY `stock_id` (`stock_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `order_notifications` -- ALTER TABLE `order_notifications` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("-- -- Constraints for table `order_notifications` -- ALTER TABLE `order_notifications` ADD CONSTRAINT `order_notifications_ibfk_1` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('order_notifications');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
