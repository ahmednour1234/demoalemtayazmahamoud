<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `customer_products`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `customer_products` -- CREATE TABLE `customer_products` ( `id` bigint(20) NOT NULL, `product_id` bigint(20) NOT NULL, `customer_id` bigint(20) NOT NULL, `price` double NOT NULL DEFAULT 0, `tax` double NOT NULL DEFAULT 0, `discount` double NOT NULL DEFAULT 0, `quantity` double NOT NULL, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `customer_products` -- ALTER TABLE `customer_products` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `customer_products` -- ALTER TABLE `customer_products` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('customer_products');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
