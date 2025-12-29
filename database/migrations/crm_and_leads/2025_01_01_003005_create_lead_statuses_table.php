<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLeadStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `lead_statuses`");
        DB::statement("CREATE TABLE `lead_statuses` ( `id` bigint(20) UNSIGNED NOT NULL, `name` varchar(100) NOT NULL, `code` varchar(50) NOT NULL, `sort_order` int(11) NOT NULL DEFAULT 100, `is_active` tinyint(1) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        DB::statement("ALTER TABLE `lead_statuses` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code` (`code`);");
        DB::statement("ALTER TABLE `lead_statuses` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;");
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
        Schema::dropIfExists('lead_statuses');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
