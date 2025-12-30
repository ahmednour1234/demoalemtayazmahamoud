<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('assets')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $assets = [
            // Sample asset data structure
            // Add actual asset data from the SQL file or application as needed
        ];

        if (!empty($assets)) {
            DB::table('assets')->insert($assets);
        }

        // Note: Add asset data from the SQL file or application as needed
        // The assets table structure: id, asset_name, description, purchase_price, additional_costs, total_cost, salvage_value, book_value, accumulated_depreciation, useful_life, commencement_date, depreciation_method, depreciation_rate, invoice_number, purchase_date, location, status, code, branch_id, created_at, updated_at
    }
}
