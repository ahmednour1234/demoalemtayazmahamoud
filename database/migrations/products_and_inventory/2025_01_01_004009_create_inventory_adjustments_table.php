<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInventoryAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `inventory_adjustments`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `inventory_adjustments` -- CREATE TABLE `inventory_adjustments` ( `id` int(10) UNSIGNED NOT NULL, `inventory_count_id` int(10) UNSIGNED DEFAULT NULL, `branch_id` int(10) UNSIGNED NOT NULL, `adjustment_date` date NOT NULL, `status` varchar(50) NOT NULL, `created_by` int(10) UNSIGNED NOT NULL, `notes` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `inventory_adjustments` -- ALTER TABLE `inventory_adjustments` ADD PRIMARY KEY (`id`), ADD KEY `idx_branch_id` (`branch_id`), ADD KEY `idx_inventory_count_id` (`inventory_count_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `inventory_adjustments` -- ALTER TABLE `inventory_adjustments` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;");
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
        Schema::dropIfExists('inventory_adjustments');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
