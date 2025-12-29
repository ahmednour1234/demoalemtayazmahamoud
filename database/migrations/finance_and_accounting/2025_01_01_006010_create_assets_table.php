<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `assets`");
        DB::statement("CREATE TABLE `assets` ( `id` int(11) NOT NULL, `asset_name` varchar(255) NOT NULL, `description` text DEFAULT NULL, `purchase_price` decimal(15,2) NOT NULL, `additional_costs` decimal(15,2) DEFAULT 0.00, `total_cost` decimal(15,2) GENERATED ALWAYS AS (`purchase_price` + `additional_costs`) STORED, `salvage_value` decimal(15,2) DEFAULT 0.00, `book_value` decimal(15,2) NOT NULL, `accumulated_depreciation` decimal(15,2) NOT NULL, `useful_life` int(11) NOT NULL, `commencement_date` date DEFAULT NULL, `depreciation_method` enum('straight_line','declining_balance','units_of_production') NOT NULL, `depreciation_rate` decimal(5,2) DEFAULT NULL, `invoice_number` varchar(100) DEFAULT NULL, `purchase_date` date DEFAULT NULL, `location` varchar(255) DEFAULT NULL, `status` enum('active','maintenance','disposed','sold','closed') DEFAULT 'active', `code` varchar(255) NOT NULL, `branch_id` bigint(20) NOT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `assets` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `assets` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;");
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
        Schema::dropIfExists('assets');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
