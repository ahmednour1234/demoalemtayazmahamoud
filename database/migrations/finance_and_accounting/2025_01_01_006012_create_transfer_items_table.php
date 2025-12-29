<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransferItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `transfer_items`");
        DB::statement("CREATE TABLE `transfer_items` ( `id` int(11) NOT NULL, `transfer_id` int(11) NOT NULL, `product_id` int(11) NOT NULL, `quantity` decimal(10,2) NOT NULL, `unit` varchar(50) NOT NULL, `cost` decimal(10,2) DEFAULT NULL, `total_cost` decimal(10,2) DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `transfer_items` ADD PRIMARY KEY (`id`), ADD KEY `transfer_id` (`transfer_id`), ADD KEY `idx_product` (`product_id`);");
        DB::statement("ALTER TABLE `transfer_items` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
        DB::statement("ALTER TABLE `transfer_items` ADD CONSTRAINT `transfer_items_ibfk_1` FOREIGN KEY (`transfer_id`) REFERENCES `transfers` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('transfer_items');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
