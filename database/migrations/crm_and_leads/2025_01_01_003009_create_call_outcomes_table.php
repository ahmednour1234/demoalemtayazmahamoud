<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCallOutcomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `call_outcomes`");
        DB::statement("CREATE TABLE `call_outcomes` ( `id` bigint(20) UNSIGNED NOT NULL, `name` varchar(100) NOT NULL, `code` varchar(50) NOT NULL, `sort_order` int(11) NOT NULL DEFAULT 1, `is_active` int(11) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        DB::statement("ALTER TABLE `call_outcomes` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code` (`code`);");
        DB::statement("ALTER TABLE `call_outcomes` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('call_outcomes');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
