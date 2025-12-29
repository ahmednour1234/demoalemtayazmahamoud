<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `expenses`");
        DB::statement("CREATE TABLE `expenses` ( `id` int(11) NOT NULL, `account_id` int(11) DEFAULT NULL, `seller_id` bigint(20) NOT NULL, `branch_id` bigint(20) NOT NULL, `cost_center_id` int(11) DEFAULT NULL, `description` varchar(255) NOT NULL, `amount` decimal(15,2) DEFAULT NULL, `date` date DEFAULT NULL, `attachment` varchar(255) DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `expenses` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `expenses` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('expenses');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
