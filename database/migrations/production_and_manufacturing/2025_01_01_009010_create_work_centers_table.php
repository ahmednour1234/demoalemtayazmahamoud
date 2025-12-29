<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWorkCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `work_centers`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `work_centers` -- CREATE TABLE `work_centers` ( `id` bigint(20) UNSIGNED NOT NULL COMMENT 'المفتاح الأساسي لمركز العمل', `name` varchar(100) NOT NULL COMMENT 'اسم مركز العمل/الآلة', `description` text DEFAULT NULL COMMENT 'وصف تفصيلي أو ملاحظات عن المركز', `capacity_per_day` decimal(8,2) DEFAULT NULL COMMENT 'ساعات العمل المتاحة في اليوم', `cost_per_hour` decimal(10,2) DEFAULT NULL COMMENT 'تكلفة التشغيل لكل ساعة', `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `branch_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'الفرع/الموقع الذي ينتمي إليه المركز', `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `work_centers` -- ALTER TABLE `work_centers` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `work_centers` -- ALTER TABLE `work_centers` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'المفتاح الأساسي لمركز العمل';");
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
        Schema::dropIfExists('work_centers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
