<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInventoryCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `inventory_counts`");
        DB::statement("CREATE TABLE `inventory_counts` ( `id` int(10) UNSIGNED NOT NULL, `branch_id` int(10) UNSIGNED NOT NULL, `count_date` date NOT NULL, `status` varchar(50) NOT NULL, `created_by` int(10) UNSIGNED NOT NULL, `notes` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `inventory_counts` ADD PRIMARY KEY (`id`), ADD KEY `idx_branch_id` (`branch_id`);");
        DB::statement("ALTER TABLE `inventory_counts` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('inventory_counts');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
