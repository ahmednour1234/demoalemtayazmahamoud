<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInventoryCountItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `inventory_count_items`");
        DB::statement("CREATE TABLE `inventory_count_items` ( `id` int(10) UNSIGNED NOT NULL, `inventory_count_id` int(10) UNSIGNED NOT NULL, `product_id` int(10) UNSIGNED NOT NULL, `system_quantity` decimal(10,2) NOT NULL, `counted_quantity` decimal(10,2) NOT NULL, `difference` decimal(10,2) GENERATED ALWAYS AS (`counted_quantity` - `system_quantity`) STORED, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `inventory_count_items` ADD PRIMARY KEY (`id`), ADD KEY `idx_inventory_count_id` (`inventory_count_id`), ADD KEY `idx_product_id` (`product_id`);");
        DB::statement("ALTER TABLE `inventory_count_items` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('inventory_count_items');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
