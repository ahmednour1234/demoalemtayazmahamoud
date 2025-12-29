<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `branches`");
        DB::statement("CREATE TABLE `branches` ( `id` bigint(20) NOT NULL, `name` varchar(255) NOT NULL, `lang` mediumtext DEFAULT NULL, `code` varchar(255) NOT NULL, `account_stock_Id` bigint(20) NOT NULL, `lat` mediumtext DEFAULT NULL, `active` int(11) NOT NULL DEFAULT 1, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `branches` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `branches` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;");
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
        Schema::dropIfExists('branches');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
