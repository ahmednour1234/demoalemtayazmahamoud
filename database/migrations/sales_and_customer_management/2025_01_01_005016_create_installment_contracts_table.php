<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInstallmentContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `installment_contracts`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `installment_contracts` -- CREATE TABLE `installment_contracts` ( `id` bigint(20) NOT NULL, `customer_id` bigint(20) NOT NULL, `guarantor_id` bigint(20) DEFAULT NULL, `total_amount` decimal(12,2) DEFAULT NULL, `start_date` date DEFAULT NULL, `duration_months` int(11) DEFAULT NULL, `interest_percent` decimal(5,2) DEFAULT 0.00, `status` enum('active','completed','cancelled') DEFAULT 'active', `order_id` bigint(20) DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `installment_contracts` -- ALTER TABLE `installment_contracts` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `installment_contracts` -- ALTER TABLE `installment_contracts` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;");
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
        Schema::dropIfExists('installment_contracts');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
