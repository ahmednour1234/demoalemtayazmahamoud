<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomerPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `customer_prices`");
        DB::statement("CREATE TABLE `customer_prices` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) NOT NULL, `customer_id` bigint(20) UNSIGNED NOT NULL, `product_id` bigint(20) UNSIGNED NOT NULL, `price` double NOT NULL, `insert_flag` tinyint(4) DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `update_flag` tinyint(4) DEFAULT 0, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
        DB::statement("ALTER TABLE `customer_prices` ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`), ADD KEY `customer_id` (`customer_id`);");
        DB::statement("ALTER TABLE `customer_prices` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;");
        DB::statement("ALTER TABLE `customer_prices` ADD CONSTRAINT `customer_prices_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `customer_prices_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('customer_prices');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
