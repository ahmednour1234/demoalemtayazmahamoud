<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransfersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transfers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $transfers = [
            // Sample transfer data structure
            // Add actual transfer data from the SQL file or application as needed
        ];

        if (!empty($transfers)) {
            DB::table('transfers')->insert($transfers);
        }

        // Note: Add transfer data from the SQL file or application as needed
        // The transfers table structure: id, transfer_number, source_branch_id, destination_branch_id, account_id, account_id_to, total_amount, created_by, approved_by, status, notes, created_at, updated_at
    }
}
