<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('salaries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $salaries = [
            // Sample salary data structure
            // Add actual salary data from the SQL file or application as needed
        ];

        if (!empty($salaries)) {
            DB::table('salaries')->insert($salaries);
        }

        // Note: Add salary data from the SQL file or application as needed
        // The salaries table structure: id, seller_id, salary, commission, number_of_visitors, result_of_visitors, salary_of_visitors, transport_amount, score, month, note, notemanager, number_of_days, discount, total, other, taxes, insurance, created_at, updated_at
    }
}
