<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateConfirmStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `confirm_stocks`");
        DB::statement("CREATE TABLE `confirm_stocks` ( `id` bigint(20) UNSIGNED NOT NULL, `product_id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `stock` int(11) NOT NULL, `main_stock` int(11) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
        DB::statement("ALTER TABLE `confirm_stocks` ADD PRIMARY KEY (`id`), ADD KEY `stock_id` (`product_id`), ADD KEY `confirm_stocks_ibfk_1` (`seller_id`);");
        DB::statement("ALTER TABLE `confirm_stocks` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;");
        DB::statement("ALTER TABLE `confirm_stocks` ADD CONSTRAINT `confirm_stocks_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `confirm_stocks_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('confirm_stocks');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
