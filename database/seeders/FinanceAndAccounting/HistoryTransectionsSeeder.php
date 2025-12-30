<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistoryTransectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('history_transections')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $historyTransections = [
            // Sample history transaction data structure
            // Add actual history transaction data from the SQL file as needed
        ];

        if (!empty($historyTransections)) {
            DB::table('history_transections')->insert($historyTransections);
        }

        // Note: Add history transaction data from the SQL file as needed
        // The history_transections table structure: id, tran_type, account_id, seller_id, amount, description, debit, credit, balance, date, customer_id, supplier_id, order_id, created_at, updated_at, company_id, img
    }
}
