<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transections')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $transections = [
            [
                'id' => 1,
                'tran_type' => '1',
                'account_id' => 151,
                'account_id_to' => null,
                'seller_id' => 160,
                'branch_id' => 1,
                'cost_id' => null,
                'cost_id_to' => null,
                'amount' => 16307.46,
                'description' => 'رصيد افتتاحي',
                'debit' => 0,
                'credit' => 16307.46,
                'balance' => -16307.46,
                'credit_account' => 16307.46,
                'debit_account' => 0,
                'balance_account' => 0,
                'balance_customer' => '0',
                'date' => '2025-01-01',
                'end_date' => null,
                'customer_id' => null,
                'supplier_id' => null,
                'order_id' => null,
                'created_at' => '2025-09-11 18:20:00',
                'updated_at' => '2025-09-11 18:20:00',
                'deleted_at' => null,
                'company_id' => 1,
                'asset_id' => null,
                'expense_id' => null,
                'tax' => 0,
                'fixed_type' => null,
                'img' => null,
                'active' => 1,
                'cash' => 1,
                'name' => null,
                'tax_number' => null,
                'tax_id' => null,
                'is_reversal' => 0,
                'salary_id' => null,
                'journal_entry_detail_id' => null,
            ],
            [
                'id' => 2,
                'tran_type' => '1',
                'account_id' => 297,
                'account_id_to' => null,
                'seller_id' => 160,
                'branch_id' => 1,
                'cost_id' => null,
                'cost_id_to' => null,
                'amount' => 16307.46,
                'description' => 'رصيد افتتاحي',
                'debit' => 16307.46,
                'credit' => 0,
                'balance' => 16307.46,
                'credit_account' => 0,
                'debit_account' => 16307.46,
                'balance_account' => 0,
                'balance_customer' => '0',
                'date' => '2025-01-01',
                'end_date' => null,
                'customer_id' => null,
                'supplier_id' => null,
                'order_id' => null,
                'created_at' => '2025-09-11 18:20:00',
                'updated_at' => '2025-09-11 18:20:00',
                'deleted_at' => null,
                'company_id' => 1,
                'asset_id' => null,
                'expense_id' => null,
                'tax' => 0,
                'fixed_type' => null,
                'img' => null,
                'active' => 1,
                'cash' => 1,
                'name' => null,
                'tax_number' => null,
                'tax_id' => null,
                'is_reversal' => 0,
                'salary_id' => null,
                'journal_entry_detail_id' => null,
            ],
        ];

        // Insert in chunks
        foreach (array_chunk($transections, 100) as $chunk) {
            DB::table('transections')->insert($chunk);
        }

        // Note: Add more transactions from the SQL file as needed
        // The SQL file contains many more transactions that can be added here
    }
}
