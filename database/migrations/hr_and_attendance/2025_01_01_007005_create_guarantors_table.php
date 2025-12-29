<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateGuarantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `guarantors`");
        DB::statement("CREATE TABLE `guarantors` ( `id` bigint(20) UNSIGNED NOT NULL, `contract_id` bigint(20) UNSIGNED NOT NULL, `name` varchar(255) NOT NULL, `phone` varchar(255) DEFAULT NULL, `address` text DEFAULT NULL, `job` varchar(255) DEFAULT NULL, `monthly_income` decimal(10,2) DEFAULT NULL, `relation` varchar(255) DEFAULT NULL, `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)), `national_id` bigint(20) DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `guarantors` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `guarantors` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('guarantors');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
