<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStockBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `stock_batches`");
        DB::statement("CREATE TABLE `stock_batches` ( `id` bigint(20) NOT NULL, `product_id` bigint(20) NOT NULL, `quantity` double NOT NULL DEFAULT 0, `price` double NOT NULL DEFAULT 0, `product_code` varchar(6555) DEFAULT NULL, `branch_id` bigint(20) NOT NULL DEFAULT 3, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `stock_batches` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `stock_batches` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('stock_batches');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
