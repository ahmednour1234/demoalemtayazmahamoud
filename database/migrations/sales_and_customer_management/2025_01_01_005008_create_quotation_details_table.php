<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateQuotationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `quotation_details`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `quotation_details` -- CREATE TABLE `quotation_details` ( `id` bigint(20) UNSIGNED NOT NULL, `product_id` bigint(20) DEFAULT NULL, `order_id` bigint(20) DEFAULT NULL, `price` double NOT NULL DEFAULT 0, `product_details` text DEFAULT NULL, `product_code` varchar(6555) DEFAULT NULL, `discount_on_product` double DEFAULT NULL, `discount_type` varchar(20) NOT NULL DEFAULT 'amount', `quantity` int(11) NOT NULL DEFAULT 1, `tax_amount` double NOT NULL DEFAULT 1, `unit` int(11) NOT NULL DEFAULT 1, `purchase_price` double NOT NULL DEFAULT 0, `quantity_returned` double NOT NULL DEFAULT 0, `extra_discount_on_product` double NOT NULL DEFAULT 0, `insert_flag` int(11) NOT NULL DEFAULT 1, `update_flag` int(11) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `quotation_details` -- ALTER TABLE `quotation_details` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `quotation_details` -- ALTER TABLE `quotation_details` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('quotation_details');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
