<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSellerCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `seller_customers`");
        DB::statement("CREATE TABLE `seller_customers` ( `id` int(11) NOT NULL, `local_id` bigint(20) NOT NULL, `customer_id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `seller_customers` ADD PRIMARY KEY (`id`), ADD KEY `customer_id` (`customer_id`), ADD KEY `seller_id` (`seller_id`);");
        DB::statement("ALTER TABLE `seller_customers` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5783;");
        DB::statement("ALTER TABLE `seller_customers` ADD CONSTRAINT `seller_customers_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `seller_customers_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('seller_customers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
