<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `salaries`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `salaries` -- CREATE TABLE `salaries` ( `id` bigint(20) NOT NULL, `seller_id` bigint(20) NOT NULL, `salary` varchar(20) NOT NULL DEFAULT '0', `commission` varchar(20) NOT NULL DEFAULT '0', `number_of_visitors` varchar(20) NOT NULL DEFAULT '0', `result_of_visitors` varchar(20) NOT NULL DEFAULT '0', `salary_of_visitors` varchar(20) NOT NULL DEFAULT '0', `transport_amount` varchar(20) NOT NULL DEFAULT '0', `score` varchar(20) NOT NULL DEFAULT '0', `month` mediumtext NOT NULL, `note` text NOT NULL DEFAULT 'لاتوجد ملاحظات', `notemanager` text NOT NULL DEFAULT 'لاتوجد ملاحظات', `number_of_days` int(11) NOT NULL DEFAULT 0, `discount` varchar(255) NOT NULL DEFAULT '0', `total` varchar(20) NOT NULL DEFAULT '0', `other` varchar(255) NOT NULL DEFAULT '0', `taxes` double NOT NULL DEFAULT 0, `insurance` double NOT NULL DEFAULT 0, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `salaries` -- ALTER TABLE `salaries` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `salaries` -- ALTER TABLE `salaries` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('salaries');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
