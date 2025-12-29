<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOauthAuthCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `oauth_auth_codes`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `oauth_auth_codes` -- CREATE TABLE `oauth_auth_codes` ( `id` varchar(100) NOT NULL, `user_id` bigint(20) UNSIGNED NOT NULL, `client_id` bigint(20) UNSIGNED NOT NULL, `scopes` text DEFAULT NULL, `revoked` tinyint(1) NOT NULL, `expires_at` datetime DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `oauth_auth_codes` -- ALTER TABLE `oauth_auth_codes` ADD PRIMARY KEY (`id`), ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);");
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
        Schema::dropIfExists('oauth_auth_codes');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
