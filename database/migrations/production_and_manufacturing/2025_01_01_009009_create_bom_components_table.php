<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBomComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `bom_components`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `bom_components` -- CREATE TABLE `bom_components` ( `id` bigint(20) UNSIGNED NOT NULL COMMENT 'المفتاح الأساسي لكل مكون في قائمة المواد', `bom_id` bigint(20) UNSIGNED NOT NULL COMMENT 'يرتبط برأس قائمة المواد في جدول bills_of_materials', `component_product_id` bigint(20) UNSIGNED NOT NULL COMMENT 'معرّف الصنف (مادة خام أو وسيط) من جدول products', `quantity` decimal(16,4) NOT NULL COMMENT 'الكمية المطلوبة من هذا الصنف لكل وحدة من المنتج النهائي', `unit` bigint(20) UNSIGNED NOT NULL COMMENT 'وحدة القياس صغري=0وكبري=1', `created_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ إضافة السطر', `updated_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ آخر تعديل للسطر', `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `bom_components` -- ALTER TABLE `bom_components` ADD PRIMARY KEY (`id`), ADD KEY `idx_bom_components_bom_id` (`bom_id`), ADD KEY `idx_bom_components_component_product_id` (`component_product_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `bom_components` -- ALTER TABLE `bom_components` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'المفتاح الأساسي لكل مكون في قائمة المواد';");
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
        Schema::dropIfExists('bom_components');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
