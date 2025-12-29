<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDevelopSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `develop_sellers`");
        DB::statement("CREATE TABLE `develop_sellers` ( `id` bigint(20) UNSIGNED NOT NULL, `admin_id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `note` text NOT NULL, `type` int(11) NOT NULL DEFAULT 0, `active` int(11) NOT NULL DEFAULT 0, `date` date DEFAULT NULL, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `develop_sellers` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `develop_sellers` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('develop_sellers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
