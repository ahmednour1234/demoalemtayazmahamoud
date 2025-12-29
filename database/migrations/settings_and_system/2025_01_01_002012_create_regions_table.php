<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `regions`");
        DB::statement("CREATE TABLE `regions` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) NOT NULL, `name` varchar(255) DEFAULT NULL, `name_en` varchar(255) DEFAULT NULL, `insert_flag` tinyint(4) DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `update_flag` tinyint(4) DEFAULT 0, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
        DB::statement("ALTER TABLE `regions` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `regions` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;");
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
        Schema::dropIfExists('regions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
