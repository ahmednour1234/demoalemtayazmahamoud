<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOauthAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `oauth_access_tokens`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `oauth_access_tokens` -- CREATE TABLE `oauth_access_tokens` ( `id` varchar(100) NOT NULL, `user_id` bigint(20) UNSIGNED DEFAULT NULL, `client_id` bigint(20) UNSIGNED NOT NULL, `name` varchar(255) DEFAULT NULL, `scopes` text DEFAULT NULL, `revoked` tinyint(1) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `expires_at` datetime DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `oauth_access_tokens` -- ALTER TABLE `oauth_access_tokens` ADD PRIMARY KEY (`id`), ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);");
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
        Schema::dropIfExists('oauth_access_tokens');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
