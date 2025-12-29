<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStockOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `stock_orders`");
        DB::statement("CREATE TABLE `stock_orders` ( `id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) UNSIGNED DEFAULT NULL, `branch_id` bigint(20) NOT NULL DEFAULT 1, `statistcs` text DEFAULT NULL, `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', `insert_flag` int(11) NOT NULL DEFAULT 1, `update_flag` int(11) NOT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `stock_orders` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `stock_orders` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('stock_orders');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
