<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOauthPersonalAccessClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `oauth_personal_access_clients`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `oauth_personal_access_clients` -- CREATE TABLE `oauth_personal_access_clients` ( `id` bigint(20) UNSIGNED NOT NULL, `client_id` bigint(20) UNSIGNED NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `oauth_personal_access_clients` -- ALTER TABLE `oauth_personal_access_clients` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `oauth_personal_access_clients` -- ALTER TABLE `oauth_personal_access_clients` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
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
        Schema::dropIfExists('oauth_personal_access_clients');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
