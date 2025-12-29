<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOauthClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `oauth_clients`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `oauth_clients` -- CREATE TABLE `oauth_clients` ( `id` bigint(20) UNSIGNED NOT NULL, `user_id` bigint(20) UNSIGNED DEFAULT NULL, `name` varchar(255) NOT NULL, `secret` varchar(100) DEFAULT NULL, `provider` varchar(255) DEFAULT NULL, `redirect` text NOT NULL, `personal_access_client` tinyint(1) NOT NULL, `password_client` tinyint(1) NOT NULL, `revoked` tinyint(1) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `oauth_clients` -- ALTER TABLE `oauth_clients` ADD PRIMARY KEY (`id`), ADD KEY `oauth_clients_user_id_index` (`user_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `oauth_clients` -- ALTER TABLE `oauth_clients` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;");
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
        Schema::dropIfExists('oauth_clients');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
