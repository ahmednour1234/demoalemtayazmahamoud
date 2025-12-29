<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOauthRefreshTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `oauth_refresh_tokens`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `oauth_refresh_tokens` -- CREATE TABLE `oauth_refresh_tokens` ( `id` varchar(100) NOT NULL, `access_token_id` varchar(100) NOT NULL, `revoked` tinyint(1) NOT NULL, `expires_at` datetime DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `oauth_refresh_tokens` -- ALTER TABLE `oauth_refresh_tokens` ADD PRIMARY KEY (`id`), ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);");
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
        Schema::dropIfExists('oauth_refresh_tokens');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
