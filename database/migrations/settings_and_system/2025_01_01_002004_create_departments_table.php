<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `departments`");
        DB::statement("CREATE TABLE `departments` ( `id` bigint(20) UNSIGNED NOT NULL, `parent_id` bigint(20) UNSIGNED DEFAULT NULL, `name` varchar(191) NOT NULL, `code` varchar(64) NOT NULL, `active` tinyint(1) NOT NULL DEFAULT 1, `level` smallint(5) UNSIGNED NOT NULL DEFAULT 0, `path` varchar(1024) DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `departments` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uniq_departments_code` (`code`), ADD KEY `idx_departments_parent` (`parent_id`), ADD KEY `idx_departments_active` (`active`), ADD KEY `idx_departments_level` (`level`);");
        DB::statement("ALTER TABLE `departments` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;");
        DB::statement("ALTER TABLE `departments` ADD CONSTRAINT `fk_departments_parent` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
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
        Schema::dropIfExists('departments');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
