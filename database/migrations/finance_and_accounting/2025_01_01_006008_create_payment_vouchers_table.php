<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePaymentVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `payment_vouchers`");
        DB::statement("CREATE TABLE `payment_vouchers` ( `id` bigint(20) UNSIGNED NOT NULL, `voucher_number` varchar(50) NOT NULL, `date` date NOT NULL, `type` enum('payment','receipt') NOT NULL, `payee_name` varchar(255) NOT NULL, `branch_id` bigint(20) UNSIGNED DEFAULT NULL, `debit_account_id` bigint(20) UNSIGNED NOT NULL, `credit_account_id` bigint(20) UNSIGNED NOT NULL, `amount` decimal(15,2) NOT NULL, `currency` char(3) DEFAULT 'SAR', `payment_method` enum('cash','bank_transfer','cheque','other') DEFAULT 'cash', `cheque_number` varchar(100) DEFAULT NULL, `description` text DEFAULT NULL, `attachment` varchar(255) DEFAULT NULL, `created_by` bigint(20) UNSIGNED NOT NULL, `journal_entry_id` bigint(20) UNSIGNED DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `payment_vouchers` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `payment_vouchers` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('payment_vouchers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
