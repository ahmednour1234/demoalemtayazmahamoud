<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCurrentReserveProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `current_reserve_products`");
        DB::statement("CREATE TABLE `current_reserve_products` ( `id` bigint(20) UNSIGNED NOT NULL, `data` text NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `customer_id` bigint(20) UNSIGNED DEFAULT NULL, `date` varchar(200) DEFAULT NULL, `type` int(11) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `insert_flag` int(11) NOT NULL DEFAULT 1, `update_flag` int(11) NOT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `current_reserve_products` ADD PRIMARY KEY (`id`), ADD KEY `seller_id` (`seller_id`), ADD KEY `customer_id` (`customer_id`);");
        DB::statement("ALTER TABLE `current_reserve_products` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('current_reserve_products');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
