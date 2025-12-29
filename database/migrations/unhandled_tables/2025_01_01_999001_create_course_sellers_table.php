<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCourseSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `course_sellers`");
        DB::statement("CREATE TABLE `course_sellers` ( `id` int(20) UNSIGNED NOT NULL, `admin_id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `name` varchar(500) NOT NULL DEFAULT 'غير معروف', `link` mediumtext DEFAULT NULL, `img` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`img`)), `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `course_sellers` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `course_sellers` MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('course_sellers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
