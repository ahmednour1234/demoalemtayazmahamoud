<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductionOrderBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `production_order_batches`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `production_order_batches` -- CREATE TABLE `production_order_batches` ( `id` bigint(20) UNSIGNED NOT NULL COMMENT 'المفتاح الأساسي لكل ربط', `production_order_id` bigint(20) UNSIGNED NOT NULL COMMENT 'معرف أمر الإنتاج (بدون قيد FK)', `stock_batch_id` bigint(20) UNSIGNED NOT NULL COMMENT 'معرف دفعة المخزون (بدون قيد FK)', `reserved_quantity` decimal(10,2) NOT NULL, `actual_quantity` decimal(10,2) NOT NULL DEFAULT 0.00, `waste_quantity` decimal(10,2) NOT NULL DEFAULT 0.00, `created_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ الإنشاء', `updated_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ آخر تعديل', `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول الربط بين أوامر الإنتاج ودفعات المخزون بدون قيود المفتاح الأجنبي';");
        DB::statement("-- -- Indexes for table `production_order_batches` -- ALTER TABLE `production_order_batches` ADD PRIMARY KEY (`id`), ADD KEY `idx_pob_prod_order` (`production_order_id`), ADD KEY `idx_pob_stock_batch` (`stock_batch_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `production_order_batches` -- ALTER TABLE `production_order_batches` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'المفتاح الأساسي لكل ربط';");
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
        Schema::dropIfExists('production_order_batches');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
