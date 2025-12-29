<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `comments`");
        DB::statement("CREATE TABLE `comments` ( `id` bigint(20) UNSIGNED NOT NULL, `entity_type` enum('task','project','lead') NOT NULL, `entity_id` bigint(20) UNSIGNED NOT NULL, `admin_id` bigint(20) UNSIGNED NOT NULL, `body` text NOT NULL, `deleted_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `comments` ADD PRIMARY KEY (`id`), ADD KEY `fk_comments_admin` (`admin_id`), ADD KEY `idx_comments_entity` (`entity_type`,`entity_id`);");
        DB::statement("ALTER TABLE `comments` ADD FULLTEXT KEY `ft_comments_body` (`body`);");
        DB::statement("ALTER TABLE `comments` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
        DB::statement("ALTER TABLE `comments` ADD CONSTRAINT `fk_comments_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);");
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
        Schema::dropIfExists('comments');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
