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
        $this->call(\Database\Seeders\FinanceAndAccounting\AccountsSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\CostCentersSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\JournalEntriesSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\JournalEntriesDetailsSeeder::class);
        $this->call(\Database\Seeders\FinanceAndAccounting\TransectionsSeeder::class);

    }
}
