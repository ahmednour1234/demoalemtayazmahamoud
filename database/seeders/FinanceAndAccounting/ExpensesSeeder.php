<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('expenses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $expenses = [
            // Sample expense data structure
            // Add actual expense data from the SQL file or application as needed
        ];

        if (!empty($expenses)) {
            DB::table('expenses')->insert($expenses);
        }

        // Note: Add expense data from the SQL file or application as needed
        // The expenses table structure: id, account_id, seller_id, branch_id, cost_center_id, description, amount, date, attachment
    }
}
