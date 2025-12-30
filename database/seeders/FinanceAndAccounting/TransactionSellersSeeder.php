<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transaction_sellers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $transactionSellers = [
            // Sample transaction seller data structure
            // Add actual transaction seller data from the SQL file or application as needed
        ];

        if (!empty($transactionSellers)) {
            DB::table('transaction_sellers')->insert($transactionSellers);
        }

        // Note: Add transaction seller data from the SQL file or application as needed
        // The transaction_sellers table structure: id, seller_id, account_id, amount, note, img, active, created_at, updated_at
    }
}
