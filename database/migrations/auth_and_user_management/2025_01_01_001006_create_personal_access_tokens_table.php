<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `personal_access_tokens`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `personal_access_tokens` -- CREATE TABLE `personal_access_tokens` ( `id` bigint(20) UNSIGNED NOT NULL, `tokenable_type` varchar(255) NOT NULL, `tokenable_id` bigint(20) UNSIGNED NOT NULL, `name` varchar(255) NOT NULL, `token` varchar(64) NOT NULL, `abilities` text DEFAULT NULL, `last_used_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `personal_access_tokens` -- ALTER TABLE `personal_access_tokens` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`), ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `personal_access_tokens` -- ALTER TABLE `personal_access_tokens` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('personal_access_tokens');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
