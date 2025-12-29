<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCostCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `cost_centers`");
        DB::statement("CREATE TABLE `cost_centers` ( `id` bigint(20) NOT NULL, `name` varchar(2555) NOT NULL, `code` varchar(255) NOT NULL, `description` mediumtext NOT NULL, `parent_id` bigint(20) DEFAULT NULL, `active` int(11) NOT NULL DEFAULT 1, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `cost_centers` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `cost_centers` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;");
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
        Schema::dropIfExists('cost_centers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
