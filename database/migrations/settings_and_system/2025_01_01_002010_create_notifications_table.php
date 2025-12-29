<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `notifications`");
        DB::statement("CREATE TABLE `notifications` ( `id` bigint(20) UNSIGNED NOT NULL, `user_id` bigint(20) UNSIGNED NOT NULL, `type` varchar(128) NOT NULL, `title` varchar(191) NOT NULL, `body` text DEFAULT NULL, `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)), `read_at` datetime DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `notifications` ADD PRIMARY KEY (`id`), ADD KEY `idx_notifications_user` (`user_id`), ADD KEY `idx_notifications_type` (`type`), ADD KEY `idx_notifications_read` (`read_at`);");
        DB::statement("ALTER TABLE `notifications` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;");
        DB::statement("ALTER TABLE `notifications` ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`);");
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
        Schema::dropIfExists('notifications');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
