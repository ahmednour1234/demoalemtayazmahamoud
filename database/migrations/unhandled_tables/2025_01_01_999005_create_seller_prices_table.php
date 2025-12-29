<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSellerPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `seller_prices`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `seller_prices` -- CREATE TABLE `seller_prices` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `product_id` bigint(20) UNSIGNED NOT NULL, `price` double NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
        DB::statement("-- -- Indexes for table `seller_prices` -- ALTER TABLE `seller_prices` ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`), ADD KEY `seller_id` (`seller_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `seller_prices` -- ALTER TABLE `seller_prices` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
        DB::statement("-- -- Constraints for table `seller_prices` -- ALTER TABLE `seller_prices` ADD CONSTRAINT `seller_prices_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `seller_prices_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('seller_prices');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
