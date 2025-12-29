<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductionOrderExecutionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `production_order_execution_items`");
        DB::statement("CREATE TABLE `production_order_execution_items` ( `id` bigint(20) NOT NULL, `execution_id` bigint(20) NOT NULL, `product_id` bigint(20) NOT NULL, `reserved_quantity` decimal(10,2) NOT NULL, `consumed_quantity` decimal(10,2) NOT NULL, `unit_cost` decimal(15,4) NOT NULL, `reserved_cost` decimal(15,4) NOT NULL, `consumed_cost` decimal(15,4) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `production_order_execution_items` ADD PRIMARY KEY (`id`), ADD KEY `idx_exec_id` (`execution_id`), ADD KEY `idx_product_id` (`product_id`);");
        DB::statement("ALTER TABLE `production_order_execution_items` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('production_order_execution_items');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
