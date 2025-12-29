<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRoutingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `routings`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `routings` -- CREATE TABLE `routings` ( `id` bigint(20) UNSIGNED NOT NULL COMMENT 'المفتاح الأساسي لكل مسار تشغيل', `bom_id` bigint(20) UNSIGNED NOT NULL COMMENT 'يرتبط بـ bills_of_materials.id (قائمة المواد)', `name` varchar(100) NOT NULL COMMENT 'اسم المسار (مثلاً: المسار القياسي للإنتاج)', `description` text DEFAULT NULL COMMENT 'وصف تفصيلي للمسار', `effective_date` date DEFAULT NULL COMMENT 'تاريخ بدء استخدام هذا المسار', `created_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ الإنشاء', `updated_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ آخر تعديل', `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `routings` -- ALTER TABLE `routings` ADD PRIMARY KEY (`id`), ADD KEY `idx_routings_bom_id` (`bom_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `routings` -- ALTER TABLE `routings` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'المفتاح الأساسي لكل مسار تشغيل';");
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
        Schema::dropIfExists('routings');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
