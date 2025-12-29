<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransactionSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `transaction_sellers`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `transaction_sellers` -- CREATE TABLE `transaction_sellers` ( `id` bigint(20) NOT NULL, `seller_id` bigint(20) NOT NULL, `account_id` bigint(20) NOT NULL, `amount` varchar(255) NOT NULL, `note` mediumtext DEFAULT NULL, `img` mediumtext NOT NULL, `active` int(11) NOT NULL DEFAULT 0, `created_at` datetime NOT NULL DEFAULT current_timestamp(), `updated_at` datetime NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `transaction_sellers` -- ALTER TABLE `transaction_sellers` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `transaction_sellers` -- ALTER TABLE `transaction_sellers` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('transaction_sellers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
