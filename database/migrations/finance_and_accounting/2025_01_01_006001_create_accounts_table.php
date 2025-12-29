<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `accounts`");
        DB::statement("-- -- Database: `u414283222_crm` -- -- -------------------------------------------------------- -- -- Table structure for table `accounts` -- CREATE TABLE `accounts` ( `id` bigint(20) UNSIGNED NOT NULL, `storage_id` bigint(20) UNSIGNED DEFAULT NULL, `account` varchar(255) NOT NULL, `description` varchar(255) DEFAULT NULL, `balance` double DEFAULT 0, `account_number` varchar(255) NOT NULL, `total_in` double DEFAULT 0, `total_out` double DEFAULT 0, `type` int(11) NOT NULL DEFAULT 0, `account_type` enum('asset','liability','equity','revenue','expense','other') NOT NULL, `code` int(11) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `parent_id` bigint(20) DEFAULT NULL, `default_cost_center_id` bigint(20) UNSIGNED DEFAULT NULL, `cost_center` varchar(20) NOT NULL DEFAULT '0' ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for dumped tables -- -- -- Indexes for table `accounts` -- ALTER TABLE `accounts` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for dumped tables -- -- -- AUTO_INCREMENT for table `accounts` -- ALTER TABLE `accounts` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;");
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
        Schema::dropIfExists('accounts');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
