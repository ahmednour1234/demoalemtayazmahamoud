<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateArchivedStockBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `archived_stock_batches`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `archived_stock_batches` -- CREATE TABLE `archived_stock_batches` ( `id` int(10) UNSIGNED NOT NULL, `product_id` int(10) UNSIGNED NOT NULL, `branch_id` int(10) UNSIGNED NOT NULL, `quantity` decimal(10,2) NOT NULL, `price` decimal(10,2) NOT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `archived_stock_batches` -- ALTER TABLE `archived_stock_batches` ADD PRIMARY KEY (`id`), ADD KEY `idx_product_branch` (`product_id`,`branch_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `archived_stock_batches` -- ALTER TABLE `archived_stock_batches` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('archived_stock_batches');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
