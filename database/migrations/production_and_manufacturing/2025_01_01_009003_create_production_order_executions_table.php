<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductionOrderExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `production_order_executions`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `production_order_executions` -- CREATE TABLE `production_order_executions` ( `id` bigint(20) NOT NULL, `production_order_id` bigint(20) NOT NULL, `branch_id` bigint(20) NOT NULL, `start_time` datetime NOT NULL, `end_time` datetime NOT NULL, `actual_hours` decimal(6,2) NOT NULL, `total_reserved_quantity` decimal(10,2) NOT NULL, `total_consumed_quantity` decimal(10,2) NOT NULL, `waste_quantity` decimal(10,2) NOT NULL, `produced_quantity` decimal(10,2) NOT NULL, `unit_cost` decimal(15,4) NOT NULL, `total_cost` decimal(15,4) NOT NULL, `additional_costs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_costs`)), `additional_cost_total` decimal(15,4) DEFAULT 0.0000, `executed_by` bigint(20) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `production_order_executions` -- ALTER TABLE `production_order_executions` ADD PRIMARY KEY (`id`), ADD KEY `idx_po_id` (`production_order_id`), ADD KEY `idx_branch_id` (`branch_id`), ADD KEY `idx_executed_by` (`executed_by`);");
        DB::statement("-- -- AUTO_INCREMENT for table `production_order_executions` -- ALTER TABLE `production_order_executions` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('production_order_executions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
