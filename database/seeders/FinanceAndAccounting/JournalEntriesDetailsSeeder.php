<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JournalEntriesDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('journal_entries_details')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $journalEntriesDetails = [
            [
                'id' => 11,
                'journal_entry_id' => 6,
                'account_id' => 151,
                'debit' => 39218.41,
                'credit' => 0.00,
                'cost_center_id' => null,
                'description' => 'حوالة ايراد مساند',
                'attachment_path' => null,
                'entry_date' => '2025-11-12',
                'asset_id' => null,
                'created_at' => '2025-11-12 03:10:06',
                'updated_at' => '2025-11-12 03:10:06',
                'deleted_at' => null,
                'reversal_of_detail_id' => null,
            ],
            [
                'id' => 12,
                'journal_entry_id' => 6,
                'account_id' => 364,
                'debit' => 0.00,
                'credit' => 39218.41,
                'cost_center_id' => null,
                'description' => 'حوالة ايراد مساند',
                'attachment_path' => null,
                'entry_date' => '2025-11-12',
                'asset_id' => null,
                'created_at' => '2025-11-12 03:10:06',
                'updated_at' => '2025-11-12 03:10:06',
                'deleted_at' => null,
                'reversal_of_detail_id' => null,
            ],
            [
                'id' => 13,
                'journal_entry_id' => 7,
                'account_id' => 151,
                'debit' => 1500.00,
                'credit' => 0.00,
                'cost_center_id' => null,
                'description' => 'ايراد من الاستقدام عوض',
                'attachment_path' => null,
                'entry_date' => '2025-11-12',
                'asset_id' => null,
                'created_at' => '2025-11-12 03:12:46',
                'updated_at' => '2025-11-12 03:12:46',
                'deleted_at' => null,
                'reversal_of_detail_id' => null,
            ],
            [
                'id' => 14,
                'journal_entry_id' => 7,
                'account_id' => 304,
                'debit' => 0.00,
                'credit' => 1500.00,
                'cost_center_id' => null,
                'description' => 'ايراد من الاستقدام عوض',
                'attachment_path' => null,
                'entry_date' => '2025-11-12',
                'asset_id' => null,
                'created_at' => '2025-11-12 03:12:46',
                'updated_at' => '2025-11-12 03:12:46',
                'deleted_at' => null,
                'reversal_of_detail_id' => null,
            ],
        ];

        // Insert in chunks
        foreach (array_chunk($journalEntriesDetails, 100) as $chunk) {
            DB::table('journal_entries_details')->insert($chunk);
        }

        // Note: Add more journal entry details from the SQL file as needed
    }
}
