<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `categories`");
        DB::statement("CREATE TABLE `categories` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) NOT NULL, `name` varchar(255) NOT NULL, `parent_id` int(11) NOT NULL, `position` int(11) NOT NULL, `status` tinyint(1) NOT NULL DEFAULT 1, `image` varchar(255) NOT NULL, `insert_flag` tinyint(4) DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `update_flag` tinyint(4) DEFAULT 0, `updated_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `type` int(11) NOT NULL DEFAULT 1, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `categories` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `categories` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;");
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
        Schema::dropIfExists('categories');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
