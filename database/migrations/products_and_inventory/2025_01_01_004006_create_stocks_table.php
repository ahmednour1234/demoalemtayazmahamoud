<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `stocks`");
        DB::statement("CREATE TABLE `stocks` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1, `store_id` int(11) DEFAULT NULL, `product_id` bigint(20) UNSIGNED NOT NULL, `main_stock` mediumtext NOT NULL, `stock` mediumtext NOT NULL, `active` int(11) NOT NULL DEFAULT 1, `price` longtext NOT NULL DEFAULT '0', `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
        DB::statement("ALTER TABLE `stocks` ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`), ADD KEY `stocks_ibfk_1` (`seller_id`);");
        DB::statement("ALTER TABLE `stocks` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2472;");
        DB::statement("ALTER TABLE `stocks` ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `stocks_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('stocks');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
