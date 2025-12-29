<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `transections`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `transections` -- CREATE TABLE `transections` ( `id` bigint(20) UNSIGNED NOT NULL, `tran_type` varchar(255) DEFAULT NULL, `account_id` bigint(20) UNSIGNED DEFAULT NULL, `account_id_to` bigint(20) UNSIGNED DEFAULT NULL, `seller_id` bigint(20) UNSIGNED DEFAULT NULL, `branch_id` bigint(20) NOT NULL DEFAULT 1, `cost_id` bigint(20) DEFAULT NULL, `cost_id_to` bigint(20) DEFAULT NULL, `amount` double DEFAULT NULL, `description` varchar(255) DEFAULT NULL, `debit` double DEFAULT 0, `credit` double DEFAULT 0, `balance` double DEFAULT 0, `credit_account` double NOT NULL DEFAULT 0, `debit_account` double NOT NULL DEFAULT 0, `balance_account` double NOT NULL DEFAULT 0, `balance_customer` mediumtext NOT NULL DEFAULT '0', `date` date DEFAULT NULL, `end_date` mediumtext DEFAULT NULL, `customer_id` int(10) UNSIGNED DEFAULT NULL, `supplier_id` int(10) UNSIGNED DEFAULT NULL, `order_id` int(10) UNSIGNED DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `asset_id` bigint(20) DEFAULT NULL, `expense_id` bigint(20) DEFAULT NULL, `tax` double NOT NULL DEFAULT 0, `fixed_type` int(11) DEFAULT NULL, `img` mediumtext DEFAULT NULL, `active` int(11) NOT NULL DEFAULT 1, `cash` int(11) NOT NULL DEFAULT 1, `name` varchar(500) DEFAULT NULL, `tax_number` varchar(500) DEFAULT NULL, `tax_id` bigint(20) DEFAULT NULL, `is_reversal` int(11) NOT NULL DEFAULT 0, `salary_id` bigint(20) DEFAULT NULL, `journal_entry_detail_id` bigint(20) DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `transections` -- ALTER TABLE `transections` ADD PRIMARY KEY (`id`), ADD KEY `seller_id` (`seller_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `transections` -- ALTER TABLE `transections` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=445;");
        DB::statement("-- -- Constraints for table `transections` -- ALTER TABLE `transections` ADD CONSTRAINT `transections_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('transections');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
