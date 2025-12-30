<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JournalEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('journal_entries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $journalEntries = [
            ['id' => 6, 'entry_date' => '2025-01-10', 'reference' => null, 'description' => 'حوالة ايراد مساند', 'created_by' => 160, 'payment_voucher_id' => null, 'type' => 'entry', 'branch_id' => 1, 'asset_id' => null, 'reversal' => 1, 'created_at' => '2025-11-12 03:10:06', 'updated_at' => '2025-11-12 03:10:06', 'deleted_at' => null, 'reversal_of_id' => null, 'head_date' => '2025-11-12 00:10:06', 'ref' => null],
            ['id' => 7, 'entry_date' => '2025-01-10', 'reference' => null, 'description' => 'ايراد من الاستقدام عوض', 'created_by' => 160, 'payment_voucher_id' => null, 'type' => 'entry', 'branch_id' => 1, 'asset_id' => null, 'reversal' => 1, 'created_at' => '2025-11-12 03:12:46', 'updated_at' => '2025-11-12 03:12:46', 'deleted_at' => null, 'reversal_of_id' => null, 'head_date' => '2025-11-12 00:12:46', 'ref' => null],
            ['id' => 8, 'entry_date' => '2025-10-01', 'reference' => null, 'description' => 'ياسمين علي هادي - استلام سلسك - رسوم استلام عاملة هدي احمد عطيه بجازان 200 اتعاب المندوب + 239 قيمة التذكرة', 'created_by' => 160, 'payment_voucher_id' => null, 'type' => 'entry', 'branch_id' => 1, 'asset_id' => null, 'reversal' => 1, 'created_at' => '2025-11-12 03:34:44', 'updated_at' => '2025-11-12 03:34:44', 'deleted_at' => null, 'reversal_of_id' => null, 'head_date' => '2025-11-12 00:34:44', 'ref' => null],
            ['id' => 9, 'entry_date' => '2025-10-01', 'reference' => null, 'description' => 'شحن نت سكن العاملات مكتب المتميز 287.5 ريال', 'created_by' => 160, 'payment_voucher_id' => null, 'type' => 'entry', 'branch_id' => 1, 'asset_id' => null, 'reversal' => 1, 'created_at' => '2025-11-12 03:35:59', 'updated_at' => '2025-11-12 03:35:59', 'deleted_at' => null, 'reversal_of_id' => null, 'head_date' => '2025-11-12 00:35:59', 'ref' => null],
            ['id' => 10, 'entry_date' => '2025-10-01', 'reference' => null, 'description' => 'ابوفواز - ارسال عامله من الحفر الي الرياض -اثيوبيا عاملة ملاك محمد الشمري', 'created_by' => 160, 'payment_voucher_id' => null, 'type' => 'entry', 'branch_id' => 1, 'asset_id' => null, 'reversal' => 1, 'created_at' => '2025-11-12 03:40:05', 'updated_at' => '2025-11-12 03:40:05', 'deleted_at' => null, 'reversal_of_id' => null, 'head_date' => '2025-11-12 00:40:05', 'ref' => null],
        ];

        // Insert in chunks
        foreach (array_chunk($journalEntries, 100) as $chunk) {
            DB::table('journal_entries')->insert($chunk);
        }

        // Note: Add more journal entries from the SQL file as needed
    }
}
