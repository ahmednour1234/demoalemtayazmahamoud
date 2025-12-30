<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransferItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transfer_items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $transferItems = [
            // Sample transfer item data structure
            // Add actual transfer item data from the SQL file or application as needed
        ];

        if (!empty($transferItems)) {
            DB::table('transfer_items')->insert($transferItems);
        }

        // Note: Add transfer item data from the SQL file or application as needed
        // The transfer_items table structure: id, transfer_id, product_id, quantity, unit, cost, total_cost, created_at, updated_at
    }
}
