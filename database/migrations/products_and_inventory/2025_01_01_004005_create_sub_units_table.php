<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSubUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `sub_units`");
        DB::statement("CREATE TABLE `sub_units` ( `id` bigint(20) UNSIGNED NOT NULL, `unit_id` bigint(20) UNSIGNED NOT NULL, `name` varchar(255) NOT NULL, `created_at` int(11) NOT NULL, `updated_at` int(11) NOT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `sub_units` ADD PRIMARY KEY (`id`), ADD KEY `unit_id` (`unit_id`);");
        DB::statement("ALTER TABLE `sub_units` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;");
        DB::statement("ALTER TABLE `sub_units` ADD CONSTRAINT `sub_units_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;");
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
        Schema::dropIfExists('sub_units');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
