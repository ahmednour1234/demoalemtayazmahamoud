<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `custom_fields`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `custom_fields` -- CREATE TABLE `custom_fields` ( `id` bigint(20) UNSIGNED NOT NULL, `name` varchar(255) NOT NULL, `key` varchar(255) NOT NULL, `type` varchar(50) NOT NULL, `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)), `default_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`default_value`)), `is_required` tinyint(1) NOT NULL DEFAULT 0, `is_active` tinyint(1) NOT NULL DEFAULT 1, `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0, `applies_to` varchar(255) NOT NULL, `group` varchar(255) DEFAULT NULL, `help_text` varchar(255) DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `custom_fields` -- ALTER TABLE `custom_fields` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `custom_fields_key_unique` (`key`), ADD KEY `custom_fields_applies_to_is_active_sort_order_index` (`applies_to`,`is_active`,`sort_order`);");
        DB::statement("-- -- AUTO_INCREMENT for table `custom_fields` -- ALTER TABLE `custom_fields` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;");
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
        Schema::dropIfExists('custom_fields');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
