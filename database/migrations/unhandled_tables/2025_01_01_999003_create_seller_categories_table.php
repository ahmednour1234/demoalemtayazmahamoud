<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSellerCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `seller_categories`");
        DB::statement("CREATE TABLE `seller_categories` ( `id` int(11) NOT NULL, `cat_id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
        DB::statement("ALTER TABLE `seller_categories` ADD PRIMARY KEY (`id`), ADD KEY `cat_id` (`cat_id`), ADD KEY `seller_categories_ibfk_2` (`seller_id`);");
        DB::statement("ALTER TABLE `seller_categories` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=665;");
        DB::statement("ALTER TABLE `seller_categories` ADD CONSTRAINT `seller_categories_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `seller_categories_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('seller_categories');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
