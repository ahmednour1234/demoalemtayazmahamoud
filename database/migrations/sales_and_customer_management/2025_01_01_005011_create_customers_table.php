<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `customers`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `customers` -- CREATE TABLE `customers` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) NOT NULL, `name` varchar(255) NOT NULL, `name_en` varchar(255) DEFAULT 'Default Customer', `mobile` varchar(255) NOT NULL, `email` varchar(255) DEFAULT NULL, `image` varchar(255) DEFAULT NULL, `state` varchar(255) DEFAULT NULL, `city` varchar(255) DEFAULT NULL, `zip_code` varchar(255) DEFAULT NULL, `address` varchar(255) DEFAULT NULL, `balance` double DEFAULT NULL, `credit` double DEFAULT 0, `type` int(11) DEFAULT 0, `latitude` varchar(2000) DEFAULT NULL, `longitude` varchar(2000) DEFAULT NULL, `active` int(11) NOT NULL DEFAULT 1, `limit` double NOT NULL DEFAULT 0, `insert_flag` tinyint(4) DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `update_flag` tinyint(4) DEFAULT 0, `updated_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `category_id` bigint(20) UNSIGNED DEFAULT NULL, `specialist` int(11) DEFAULT 1, `region_id` bigint(20) NOT NULL DEFAULT 1, `pharmacy_name` varchar(5000) DEFAULT NULL, `tax_number` varchar(255) NOT NULL DEFAULT '0', `c_history` varchar(255) NOT NULL DEFAULT '0', `discount` double NOT NULL DEFAULT 0, `account_id` bigint(20) DEFAULT NULL, `guarantor_id` bigint(20) DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `customers` -- ALTER TABLE `customers` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `customers` -- ALTER TABLE `customers` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;");
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
        Schema::dropIfExists('customers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
