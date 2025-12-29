<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `product_logs`");
        DB::statement("CREATE TABLE `product_logs` ( `id` bigint(20) NOT NULL, `product_id` bigint(20) NOT NULL, `branch_id` bigint(20) NOT NULL DEFAULT 1, `seller_id` bigint(20) NOT NULL DEFAULT 100, `quantity` mediumtext NOT NULL, `type` varchar(2555) NOT NULL DEFAULT '1', `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `product_logs` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `product_logs` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('product_logs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
