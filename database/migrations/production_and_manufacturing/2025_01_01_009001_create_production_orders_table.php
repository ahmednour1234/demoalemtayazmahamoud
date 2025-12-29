<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductionOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `production_orders`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `production_orders` -- CREATE TABLE `production_orders` ( `id` bigint(20) UNSIGNED NOT NULL COMMENT 'المفتاح الأساسي', `product_id` bigint(20) UNSIGNED NOT NULL COMMENT 'يربط بالمنتج (بدون FK)', `bom_id` bigint(20) UNSIGNED NOT NULL COMMENT 'يربط بـBOM (بدون FK)', `routing_id` bigint(20) UNSIGNED NOT NULL COMMENT 'يربط بالمسار (بدون FK)', `branch_id` bigint(20) UNSIGNED NOT NULL COMMENT 'يربط بالفرع (بدون FK)', `issued_by` bigint(20) UNSIGNED NOT NULL COMMENT 'المستخدم الصادر للأمر (بدون FK)', `quantity` decimal(10,2) NOT NULL COMMENT 'الكمية المراد تصنيعها', `unit` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=صغرى،0=كبرى', `cost_price` double NOT NULL DEFAULT 0, `produced_quantity` double NOT NULL DEFAULT 0, `start_date` date DEFAULT NULL COMMENT 'تاريخ البداية المخطط', `end_date` date DEFAULT NULL COMMENT 'تاريخ الانتهاء المخطط', `status` enum('draft','planned','in_progress','completed','cancelled') NOT NULL DEFAULT 'draft' COMMENT 'حالة الأمر', `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `production_orders` -- ALTER TABLE `production_orders` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `production_orders` -- ALTER TABLE `production_orders` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'المفتاح الأساسي';");
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
        Schema::dropIfExists('production_orders');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
