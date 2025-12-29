<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRoutingOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `routing_operations`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `routing_operations` -- CREATE TABLE `routing_operations` ( `id` bigint(20) UNSIGNED NOT NULL COMMENT 'المفتاح الأساسي لكل خطوة تشغيل', `routing_id` bigint(20) UNSIGNED NOT NULL COMMENT 'يرتبط بالمسار من جدول routings', `work_center_id` bigint(20) UNSIGNED NOT NULL COMMENT 'يرتبط بمركز العمل من جدول work_centers', `sequence` int(10) UNSIGNED NOT NULL COMMENT 'ترتيب تنفيذ الخطوة ضمن المسار', `setup_time` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'زمن الإعداد قبل التشغيل (بالساعات)', `run_time` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'زمن التشغيل لكل وحدة أو دفعة (بالساعات)', `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `routing_operations` -- ALTER TABLE `routing_operations` ADD PRIMARY KEY (`id`), ADD KEY `idx_routing_ops_routing_id` (`routing_id`), ADD KEY `idx_routing_ops_work_center_id` (`work_center_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `routing_operations` -- ALTER TABLE `routing_operations` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'المفتاح الأساسي لكل خطوة تشغيل';");
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
        Schema::dropIfExists('routing_operations');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
