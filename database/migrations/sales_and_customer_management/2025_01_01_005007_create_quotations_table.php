<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `quotations`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `quotations` -- CREATE TABLE `quotations` ( `id` bigint(20) UNSIGNED NOT NULL, `user_id` bigint(20) UNSIGNED DEFAULT NULL, `supplier_id` bigint(20) DEFAULT NULL, `parent_id` bigint(20) DEFAULT NULL, `stock_id` bigint(20) UNSIGNED DEFAULT NULL, `owner_id` bigint(20) UNSIGNED DEFAULT NULL, `branch_id` bigint(20) NOT NULL DEFAULT 1, `session_id` bigint(20) DEFAULT NULL, `owner_role` varchar(10) NOT NULL DEFAULT 'admin', `order_amount` double NOT NULL DEFAULT 0, `total_tax` double NOT NULL, `collected_cash` double DEFAULT NULL, `extra_discount` double DEFAULT NULL, `coupon_code` varchar(255) DEFAULT NULL, `coupon_discount_amount` double NOT NULL DEFAULT 0, `coupon_discount_title` varchar(255) DEFAULT NULL, `payment_id` bigint(20) UNSIGNED DEFAULT NULL, `transaction_reference` varchar(255) DEFAULT '0', `insert_flag` int(11) NOT NULL DEFAULT 1, `update_flag` int(11) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `type` varchar(222) DEFAULT '4', `cash` int(11) NOT NULL DEFAULT 1, `notification` int(11) NOT NULL DEFAULT 1, `active` int(11) NOT NULL DEFAULT 1, `img` mediumtext DEFAULT NULL, `date` timestamp NOT NULL DEFAULT current_timestamp(), `qrcode` mediumtext DEFAULT NULL, `discoun_on_products` double NOT NULL DEFAULT 0, `status` int(11) NOT NULL DEFAULT 1, `quotation_type` varchar(255) NOT NULL DEFAULT 'product', `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `quotations` -- ALTER TABLE `quotations` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `quotations` -- ALTER TABLE `quotations` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('quotations');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
