<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `products`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `products` -- CREATE TABLE `products` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) NOT NULL, `name` varchar(255) NOT NULL, `name_en` varchar(255) NOT NULL DEFAULT 'Default product', `product_code` varchar(255) NOT NULL, `unit_type` int(10) UNSIGNED DEFAULT NULL, `unit_value` double(8,2) DEFAULT NULL, `brand` varchar(255) DEFAULT NULL, `category_id` varchar(255) DEFAULT NULL, `purchase_price` double DEFAULT NULL, `purchase_price1` double NOT NULL, `purchase_price2` double NOT NULL, `purchase_price3` double NOT NULL, `purchase_price4` double NOT NULL, `selling_price` double DEFAULT NULL, `selling_price1` double NOT NULL, `selling_price2` double NOT NULL, `selling_price3` double NOT NULL, `selling_price4` double NOT NULL, `discount_type` varchar(255) DEFAULT NULL, `discount` double(8,2) DEFAULT NULL, `limit_stock` int(11) NOT NULL DEFAULT 10, `limit_web` int(11) NOT NULL DEFAULT 2, `tax` double(8,2) DEFAULT NULL, `main_quantity` mediumtext NOT NULL DEFAULT '0', `quantity` varchar(20) DEFAULT NULL, `image` varchar(255) DEFAULT NULL, `order_count` int(10) UNSIGNED DEFAULT NULL, `refund_count` int(11) NOT NULL DEFAULT 0, `purchase_count` int(11) NOT NULL DEFAULT 0, `repurchase_count` int(11) NOT NULL DEFAULT 0, `supplier_id` int(10) UNSIGNED DEFAULT NULL, `insert_flag` tinyint(4) DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `update_flag` tinyint(4) DEFAULT 0, `updated_at` timestamp NULL DEFAULT NULL, `expiry_date` timestamp NOT NULL DEFAULT current_timestamp(), `company_id` bigint(20) DEFAULT 1, `type` varchar(255) NOT NULL, `tax_id` int(11) DEFAULT NULL, `branch_3` varchar(255) NOT NULL DEFAULT '0', `branch_4` varchar(255) NOT NULL DEFAULT '0', `branch_5` varchar(255) NOT NULL DEFAULT '0', `branch_6` varchar(255) NOT NULL DEFAULT '0', `branch_7` varchar(255) NOT NULL DEFAULT '0', `product_type` varchar(255) NOT NULL DEFAULT 'product', `branch_8` varchar(255) NOT NULL DEFAULT '0', `branch_9` varchar(255) NOT NULL DEFAULT '0', `branch_10` varchar(255) NOT NULL DEFAULT '0', `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `products` -- ALTER TABLE `products` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `products` -- ALTER TABLE `products` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;");
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
        Schema::dropIfExists('products');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
