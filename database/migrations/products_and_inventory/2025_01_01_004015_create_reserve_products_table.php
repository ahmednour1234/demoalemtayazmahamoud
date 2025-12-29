<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateReserveProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `reserve_products`");
        DB::statement("CREATE TABLE `reserve_products` ( `id` bigint(20) UNSIGNED NOT NULL, `data` text NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `customer_id` bigint(20) UNSIGNED DEFAULT NULL, `branch_id` bigint(20) NOT NULL DEFAULT 1, `date` varchar(200) DEFAULT current_timestamp(), `type` varchar(255) DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp(), `active` int(11) NOT NULL DEFAULT 1, `notification` int(11) NOT NULL DEFAULT 1, `insert_flag` int(11) NOT NULL DEFAULT 1, `update_flag` int(11) NOT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `reserve_products` ADD PRIMARY KEY (`id`), ADD KEY `seller_id` (`seller_id`);");
        DB::statement("ALTER TABLE `reserve_products` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("ALTER TABLE `reserve_products` ADD CONSTRAINT `reserve_products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('reserve_products');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
