<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `companies`");
        DB::statement("CREATE TABLE `companies` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) DEFAULT NULL, `company_name` varchar(255) DEFAULT NULL, `sub_domain_prefix` varchar(255) DEFAULT NULL, `insert_flag` tinyint(4) DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `update_flag` tinyint(4) DEFAULT 0, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `companies` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `companies` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
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
        Schema::dropIfExists('companies');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
