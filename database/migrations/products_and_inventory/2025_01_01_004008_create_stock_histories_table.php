<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `stock_histories`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `stock_histories` -- CREATE TABLE `stock_histories` ( `id` bigint(20) UNSIGNED NOT NULL, `order_id` bigint(20) UNSIGNED NOT NULL, `product_id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `stock` int(11) NOT NULL, `main_stock` int(11) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
        DB::statement("-- -- Indexes for table `stock_histories` -- ALTER TABLE `stock_histories` ADD PRIMARY KEY (`id`), ADD KEY `stock_id` (`product_id`), ADD KEY `confirm_stocks_ibfk_1` (`seller_id`), ADD KEY `order_id` (`order_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `stock_histories` -- ALTER TABLE `stock_histories` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("-- -- Constraints for table `stock_histories` -- ALTER TABLE `stock_histories` ADD CONSTRAINT `stock_histories_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `stock_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('stock_histories');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
