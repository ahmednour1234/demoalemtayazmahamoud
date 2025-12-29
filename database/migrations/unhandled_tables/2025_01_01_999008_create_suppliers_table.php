<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `suppliers`");
        DB::statement("CREATE TABLE `suppliers` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) NOT NULL, `name` varchar(255) NOT NULL, `mobile` varchar(255) NOT NULL, `email` varchar(255) DEFAULT NULL, `image` varchar(255) DEFAULT NULL, `state` varchar(255) DEFAULT NULL, `city` varchar(255) DEFAULT NULL, `zip_code` varchar(255) DEFAULT NULL, `address` varchar(255) DEFAULT NULL, `due_amount` double DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `type` int(11) NOT NULL DEFAULT 0, `credit` double NOT NULL DEFAULT 0, `discount` double NOT NULL DEFAULT 0, `active` int(11) NOT NULL DEFAULT 1, `limit` double NOT NULL DEFAULT 0, `tax_number` varchar(2550) NOT NULL DEFAULT '0', `c_history` varchar(2550) NOT NULL DEFAULT '0', `account_id` bigint(20) DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `suppliers` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `suppliers` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;");
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
        Schema::dropIfExists('suppliers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
