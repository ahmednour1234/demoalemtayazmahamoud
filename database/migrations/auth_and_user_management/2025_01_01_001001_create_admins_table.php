<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `admins`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `admins` -- CREATE TABLE `admins` ( `id` bigint(20) UNSIGNED NOT NULL, `local_id` bigint(20) NOT NULL, `f_name` varchar(255) NOT NULL, `l_name` varchar(255) NOT NULL, `name_en` varchar(255) NOT NULL DEFAULT 'Default Name', `email` varchar(255) NOT NULL, `phone` varchar(255) DEFAULT NULL, `password` varchar(255) NOT NULL, `remember_token` varchar(100) DEFAULT NULL, `insert_flag` tinyint(4) DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `update_flag` tinyint(4) DEFAULT 0, `updated_at` timestamp NULL DEFAULT NULL, `image` varchar(255) DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `mandob_code` varchar(255) DEFAULT NULL, `vehicle_code` varchar(255) DEFAULT NULL, `type` varchar(20) DEFAULT NULL, `role` varchar(6) NOT NULL DEFAULT 'admin', `dashboard` int(11) NOT NULL DEFAULT 0, `pos` int(11) NOT NULL DEFAULT 0, `stock` int(11) NOT NULL DEFAULT 0, `store` int(11) NOT NULL DEFAULT 0, `cat` int(11) NOT NULL DEFAULT 0, `unit` int(11) NOT NULL DEFAULT 0, `product` int(11) NOT NULL DEFAULT 0, `stock_limit` int(11) NOT NULL DEFAULT 0, `coupons` int(11) NOT NULL DEFAULT 0, `customer` int(11) NOT NULL DEFAULT 0, `seller` int(11) NOT NULL DEFAULT 0, `admin` int(11) NOT NULL DEFAULT 0, `supplier` int(11) NOT NULL DEFAULT 0, `setting` int(11) NOT NULL DEFAULT 0, `requests` int(11) NOT NULL DEFAULT 0, `storage` int(11) NOT NULL DEFAULT 0, `notification` int(11) NOT NULL DEFAULT 0, `tracking` int(11) NOT NULL DEFAULT 0, `vehicle_stock` int(11) NOT NULL DEFAULT 0, `reports` int(11) NOT NULL DEFAULT 0, `regions` int(11) NOT NULL DEFAULT 0, `sales` int(11) NOT NULL DEFAULT 1, `accounts` int(11) NOT NULL DEFAULT 1, `rating` int(11) NOT NULL DEFAULT 1, `visit` int(11) NOT NULL DEFAULT 1, `sectionsalary` int(11) NOT NULL DEFAULT 1, `latitude` varchar(2000) DEFAULT '1', `longitude` varchar(2000) DEFAULT '1', `visitors` int(11) NOT NULL DEFAULT 0, `result_visitors` int(11) NOT NULL DEFAULT 0, `salary` varchar(255) NOT NULL DEFAULT '0', `precent_of_sales` varchar(255) NOT NULL DEFAULT '0', `commission` varchar(5000) NOT NULL DEFAULT '0', `balance` varchar(255) NOT NULL DEFAULT '0', `credit` varchar(255) NOT NULL DEFAULT '0', `loan` double NOT NULL DEFAULT 0, `score` varchar(20) NOT NULL DEFAULT '0', `note` mediumtext DEFAULT '\'\'', `holidays` int(11) NOT NULL DEFAULT 0, `number_of_days` int(11) NOT NULL DEFAULT 0, `role_id` bigint(20) DEFAULT 1, `branch_id` bigint(20) NOT NULL DEFAULT 1, `shift_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`shift_id`)), `account_id` bigint(20) DEFAULT NULL, `department_id` bigint(20) UNSIGNED DEFAULT NULL, `manager_id` bigint(20) UNSIGNED DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `admins` -- ALTER TABLE `admins` ADD PRIMARY KEY (`id`), ADD KEY `idx_admins_department_id` (`department_id`), ADD KEY `idx_admins_manager_id` (`manager_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `admins` -- ALTER TABLE `admins` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;");
        DB::statement("-- -- Constraints for dumped tables -- -- -- Constraints for table `admins` -- ALTER TABLE `admins` ADD CONSTRAINT `fk_admins_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, ADD CONSTRAINT `fk_admins_manager` FOREIGN KEY (`manager_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
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
        Schema::dropIfExists('admins');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
