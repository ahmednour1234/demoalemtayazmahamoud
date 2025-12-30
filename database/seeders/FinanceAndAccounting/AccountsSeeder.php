<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('accounts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $accounts = [
            ['id' => 1, 'storage_id' => null, 'account' => 'أصول متداولة', 'description' => 'أصول متداولة', 'balance' => 0, 'account_number' => '', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'asset', 'code' => 11, 'created_at' => '2025-03-03 18:51:51', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => null, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 4, 'storage_id' => null, 'account' => 'اصول غير متداولة.', 'description' => 'اصول غير متداولة.', 'balance' => 0, 'account_number' => '10102', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'asset', 'code' => 12, 'created_at' => '2025-03-03 21:35:31', 'updated_at' => '2025-09-11 15:25:14', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => null, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 8, 'storage_id' => null, 'account' => 'الصناديق', 'description' => 'الصناديق', 'balance' => 0, 'account_number' => '101', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'asset', 'code' => 111, 'created_at' => '2025-03-03 22:44:27', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 1, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 14, 'storage_id' => null, 'account' => 'البنوك', 'description' => 'البنوك', 'balance' => 0, 'account_number' => '1012', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'asset', 'code' => 112, 'created_at' => '2025-03-03 22:49:43', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 1, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 15, 'storage_id' => null, 'account' => 'العملاء', 'description' => 'العملاء', 'balance' => 0, 'account_number' => '1014', 'total_in' => 0, 'total_out' => 0, 'type' => 1, 'account_type' => 'asset', 'code' => 113, 'created_at' => '2025-03-03 22:50:15', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 1, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 16, 'storage_id' => null, 'account' => 'المخزون', 'description' => 'المخزون', 'balance' => 0, 'account_number' => '1015', 'total_in' => 0, 'total_out' => 0, 'type' => 1, 'account_type' => 'asset', 'code' => 114, 'created_at' => '2025-03-03 22:50:39', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 1, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 17, 'storage_id' => null, 'account' => 'العهد', 'description' => 'العهد', 'balance' => 0, 'account_number' => '1016', 'total_in' => 0, 'total_out' => 0, 'type' => 1, 'account_type' => 'asset', 'code' => 115, 'created_at' => '2025-03-03 22:51:03', 'updated_at' => '2025-09-14 13:56:38', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 1, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 18, 'storage_id' => null, 'account' => 'الممتلكات والمعدات', 'description' => 'الممتلكات والمعدات', 'balance' => 0, 'account_number' => '10156', 'total_in' => 0, 'total_out' => 0, 'type' => 1, 'account_type' => 'asset', 'code' => 121, 'created_at' => '2025-03-03 22:51:34', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 4, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 24, 'storage_id' => null, 'account' => 'الالتزامات المتداولة', 'description' => 'الالتزامات المتداولة', 'balance' => 0, 'account_number' => '25497', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'liability', 'code' => 21, 'created_at' => '2025-03-03 22:53:51', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => null, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 25, 'storage_id' => null, 'account' => 'الالتزامات غير المتداولة', 'description' => 'الالتزامات غير المتداولة', 'balance' => 0, 'account_number' => '647', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'liability', 'code' => 22, 'created_at' => '2025-03-03 22:54:17', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => null, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 26, 'storage_id' => null, 'account' => 'الدائنون', 'description' => 'دائنون', 'balance' => 0, 'account_number' => '254484', 'total_in' => 0, 'total_out' => 0, 'type' => 1, 'account_type' => 'liability', 'code' => 211, 'created_at' => '2025-03-03 22:54:43', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 24, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 28, 'storage_id' => null, 'account' => 'ذمم دائنة اخرى', 'description' => 'ذمم دائنة اخرى', 'balance' => 0, 'account_number' => '51151', 'total_in' => 0, 'total_out' => 0, 'type' => 1, 'account_type' => 'liability', 'code' => 212, 'created_at' => '2025-03-03 22:55:45', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 24, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 29, 'storage_id' => null, 'account' => 'الرواتب المستحقة', 'description' => 'الرواتب المستحقة', 'balance' => 0, 'account_number' => '466479', 'total_in' => 0, 'total_out' => 0, 'type' => 1, 'account_type' => 'liability', 'code' => 213, 'created_at' => '2025-03-03 22:56:16', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 24, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 30, 'storage_id' => null, 'account' => 'مصروفات مستحقة', 'description' => 'مصروفات مستحقة', 'balance' => 0, 'account_number' => '661313', 'total_in' => 0, 'total_out' => 0, 'type' => 1, 'account_type' => 'liability', 'code' => 214, 'created_at' => '2025-03-03 22:56:39', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 24, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 31, 'storage_id' => null, 'account' => 'اطراف ذات علاقة', 'description' => 'اطراف ذات علاقة', 'balance' => 0, 'account_number' => '32316', 'total_in' => 0, 'total_out' => 0, 'type' => 1, 'account_type' => 'liability', 'code' => 215, 'created_at' => '2025-03-03 22:57:03', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 24, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 35, 'storage_id' => null, 'account' => 'رأس المال', 'description' => 'رأس المال', 'balance' => 0, 'account_number' => '212121', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'equity', 'code' => 31, 'created_at' => '2025-03-03 22:58:45', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => null, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 37, 'storage_id' => null, 'account' => 'جارى الشركاء', 'description' => 'جارى الشركاء', 'balance' => 0, 'account_number' => '65959', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'equity', 'code' => 32, 'created_at' => '2025-03-03 22:59:36', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => null, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 40, 'storage_id' => null, 'account' => 'الايرادات', 'description' => 'الايرادات', 'balance' => 0, 'account_number' => '9559797', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'revenue', 'code' => 41, 'created_at' => '2025-03-03 23:00:32', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => null, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 44, 'storage_id' => null, 'account' => 'المصروفات..', 'description' => 'المصروفات..', 'balance' => 0, 'account_number' => '569', 'total_in' => 0, 'total_out' => 0, 'type' => 0, 'account_type' => 'expense', 'code' => 51, 'created_at' => '2025-03-03 23:01:58', 'updated_at' => '2025-08-14 17:58:34', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => null, 'default_cost_center_id' => null, 'cost_center' => '0'],
            ['id' => 151, 'storage_id' => null, 'account' => 'بنك الراجحى', 'description' => 'بنك الراجحى', 'balance' => 107915.35, 'account_number' => '11210001', 'total_in' => 948018.27, 'total_out' => 840102.92, 'type' => 0, 'account_type' => 'asset', 'code' => 11210001, 'created_at' => '2025-08-14 18:36:51', 'updated_at' => '2025-11-12 17:10:14', 'deleted_at' => null, 'company_id' => 1, 'parent_id' => 141, 'default_cost_center_id' => null, 'cost_center' => '0'],
        ];

        // Insert accounts in chunks to avoid memory issues
        foreach (array_chunk($accounts, 100) as $chunk) {
            DB::table('accounts')->insert($chunk);
        }

        // Note: For a complete seeder, you would need to extract all accounts from the SQL file
        // This is a sample of the main accounts. You can add more accounts from the SQL file as needed.
    }
}
