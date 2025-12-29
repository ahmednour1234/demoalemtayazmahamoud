<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `custom_field_values`");
        DB::statement("CREATE TABLE `custom_field_values` ( `id` bigint(20) UNSIGNED NOT NULL, `custom_field_id` bigint(20) UNSIGNED NOT NULL, `fieldable_type` varchar(255) NOT NULL, `fieldable_id` bigint(20) UNSIGNED NOT NULL, `value` longtext DEFAULT NULL, `value_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value_json`)), `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `custom_field_values` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `cf_unique_per_model` (`custom_field_id`,`fieldable_type`,`fieldable_id`), ADD KEY `custom_field_values_fieldable_type_fieldable_id_index` (`fieldable_type`,`fieldable_id`);");
        DB::statement("ALTER TABLE `custom_field_values` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;");
        DB::statement("ALTER TABLE `custom_field_values` ADD CONSTRAINT `custom_field_values_custom_field_id_foreign` FOREIGN KEY (`custom_field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('custom_field_values');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
