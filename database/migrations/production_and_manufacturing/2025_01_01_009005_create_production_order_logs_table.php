<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductionOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `production_order_logs`");
        DB::statement("CREATE TABLE `production_order_logs` ( `id` bigint(20) UNSIGNED NOT NULL, `production_order_id` bigint(20) UNSIGNED NOT NULL, `user_id` bigint(20) UNSIGNED NOT NULL, `action` varchar(20) NOT NULL COMMENT 'create|update|status_change', `old_values` text DEFAULT NULL COMMENT 'JSON من القيم السابقة', `new_values` text DEFAULT NULL COMMENT 'JSON من القيم الجديدة', `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        DB::statement("ALTER TABLE `production_order_logs` ADD PRIMARY KEY (`id`), ADD KEY `production_order_id` (`production_order_id`), ADD KEY `user_id` (`user_id`);");
        DB::statement("ALTER TABLE `production_order_logs` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('production_order_logs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
