<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentVouchersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('payment_vouchers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $paymentVouchers = [
            // Sample payment voucher data structure
            // Add actual payment voucher data from the SQL file or application as needed
        ];

        if (!empty($paymentVouchers)) {
            DB::table('payment_vouchers')->insert($paymentVouchers);
        }

        // Note: Add payment voucher data from the SQL file or application as needed
        // The payment_vouchers table structure: id, voucher_number, date, type, payee_name, branch_id, debit_account_id, credit_account_id, amount, currency, payment_method, cheque_number, description, attachment, created_by, journal_entry_id, created_at, updated_at
    }
}
