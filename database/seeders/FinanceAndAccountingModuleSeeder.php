<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FinanceAndAccountingModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed base tables first (no dependencies)
        $this->call(\Database\Seeders\FinanceAndAccounting\AccountsSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\CostCentersSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\SalariesSeeder::class);
        
        // Seed tables that depend on accounts
        $this->call(\Database\Seeders\FinanceAndAccounting\AssetsSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\TransectionsSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\HistoryTransectionsSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\ExpensesSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\TransactionSellersSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\TransfersSeeder::class);
        
        // Seed journal entries (depends on accounts and cost centers)
        $this->call(\Database\Seeders\FinanceAndAccounting\JournalEntriesSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\JournalEntriesDetailsSeeder::class);
        
        // Seed payment vouchers (depends on accounts and journal entries)
        $this->call(\Database\Seeders\FinanceAndAccounting\PaymentVouchersSeeder::class);
        
        // Seed transfer items (depends on transfers)
        $this->call(\Database\Seeders\FinanceAndAccounting\TransferItemsSeeder::class);
    }
}
