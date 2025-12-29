<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `transfers`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `transfers` -- CREATE TABLE `transfers` ( `id` int(11) NOT NULL, `transfer_number` varchar(50) NOT NULL, `source_branch_id` int(11) NOT NULL, `destination_branch_id` int(11) NOT NULL, `account_id` int(11) NOT NULL, `account_id_to` int(11) NOT NULL, `total_amount` decimal(10,2) NOT NULL, `created_by` int(11) NOT NULL, `approved_by` int(11) DEFAULT NULL, `status` enum('pending','approved','rejected') DEFAULT 'pending', `notes` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `transfers` -- ALTER TABLE `transfers` ADD PRIMARY KEY (`id`), ADD KEY `idx_source_branch` (`source_branch_id`), ADD KEY `idx_destination_branch` (`destination_branch_id`), ADD KEY `idx_account` (`account_id`), ADD KEY `idx_account_to` (`account_id_to`);");
        DB::statement("-- -- AUTO_INCREMENT for table `transfers` -- ALTER TABLE `transfers` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('transfers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
