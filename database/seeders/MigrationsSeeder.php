<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('migrations')->truncate();

        $data = [
            [
                'id' => 1,
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => 1,
            ],
            [
                'id' => 2,
                'migration' => '2014_10_12_100000_create_password_resets_table',
                'batch' => 1,
            ],
            [
                'id' => 3,
                'migration' => '2019_08_19_000000_create_failed_jobs_table',
                'batch' => 1,
            ],
            [
                'id' => 4,
                'migration' => '2019_12_14_000001_create_personal_access_tokens_table',
                'batch' => 1,
            ],
            [
                'id' => 5,
                'migration' => '2021_11_02_095022_create_business_settings_table',
                'batch' => 1,
            ],
            [
                'id' => 6,
                'migration' => '2021_11_02_114801_create_admins_table',
                'batch' => 1,
            ],
            [
                'id' => 7,
                'migration' => '2021_11_03_044923_create_categories_table',
                'batch' => 1,
            ],
            [
                'id' => 8,
                'migration' => '2021_11_03_090927_create_brands_table',
                'batch' => 1,
            ],
            [
                'id' => 9,
                'migration' => '2021_11_03_101237_create_products_table',
                'batch' => 1,
            ],
            [
                'id' => 10,
                'migration' => '2021_11_06_025604_create_currencies_table',
                'batch' => 1,
            ],
            [
                'id' => 11,
                'migration' => '2021_11_06_031804_create_orders_table',
                'batch' => 1,
            ],
            [
                'id' => 12,
                'migration' => '2021_11_06_084528_create_order_details_table',
                'batch' => 1,
            ],
            [
                'id' => 13,
                'migration' => '2021_11_08_094042_create_customers_table',
                'batch' => 1,
            ],
            [
                'id' => 15,
                'migration' => '2021_11_11_051704_create_coupons_table',
                'batch' => 1,
            ],
            [
                'id' => 16,
                'migration' => '2021_11_13_100539_create_units_table',
                'batch' => 1,
            ],
            [
                'id' => 17,
                'migration' => '2021_11_17_034203_create_accounts_table',
                'batch' => 1,
            ],
            [
                'id' => 20,
                'migration' => '2021_11_17_083502_create_transections_table',
                'batch' => 2,
            ],
            [
                'id' => 21,
                'migration' => '2021_11_09_064445_create_suppliers_table',
                'batch' => 3,
            ],
            [
                'id' => 22,
                'migration' => '2021_06_17_054551_create_soft_credentials_table',
                'batch' => 4,
            ],
            [
                'id' => 23,
                'migration' => '2021_12_01_141901_add_phone_col_admin',
                'batch' => 4,
            ],
            [
                'id' => 24,
                'migration' => '2021_12_02_092539_add_image_to_admin_tables',
                'batch' => 4,
            ],
            [
                'id' => 25,
                'migration' => '2016_06_01_000001_create_oauth_auth_codes_table',
                'batch' => 5,
            ],
            [
                'id' => 26,
                'migration' => '2016_06_01_000002_create_oauth_access_tokens_table',
                'batch' => 5,
            ],
            [
                'id' => 27,
                'migration' => '2016_06_01_000003_create_oauth_refresh_tokens_table',
                'batch' => 5,
            ],
            [
                'id' => 28,
                'migration' => '2016_06_01_000004_create_oauth_clients_table',
                'batch' => 5,
            ],
            [
                'id' => 29,
                'migration' => '2016_06_01_000005_create_oauth_personal_access_clients_table',
                'batch' => 5,
            ],
            [
                'id' => 30,
                'migration' => '2022_02_06_115834_create_companies_table',
                'batch' => 5,
            ],
            [
                'id' => 31,
                'migration' => '2022_02_06_121739_add_company_id_col_admin',
                'batch' => 5,
            ],
            [
                'id' => 32,
                'migration' => '2022_02_06_150041_add_company_id_category',
                'batch' => 5,
            ],
            [
                'id' => 33,
                'migration' => '2022_02_06_151731_add_company_id_brand',
                'batch' => 5,
            ],
            [
                'id' => 34,
                'migration' => '2022_02_06_152243_add_company_id_accounts',
                'batch' => 5,
            ],
            [
                'id' => 35,
                'migration' => '2022_02_06_152301_add_company_id_coupon',
                'batch' => 5,
            ],
            [
                'id' => 36,
                'migration' => '2022_02_06_152323_add_company_id_users',
                'batch' => 5,
            ],
            [
                'id' => 37,
                'migration' => '2022_02_06_152357_add_company_id_orders',
                'batch' => 5,
            ],
            [
                'id' => 38,
                'migration' => '2022_02_06_152412_add_company_id_order_details',
                'batch' => 5,
            ],
            [
                'id' => 39,
                'migration' => '2022_02_06_152429_add_company_id_products',
                'batch' => 5,
            ],
            [
                'id' => 40,
                'migration' => '2022_02_06_152453_add_company_id_suppliers',
                'batch' => 5,
            ],
            [
                'id' => 41,
                'migration' => '2022_02_06_152515_add_company_id_transactions',
                'batch' => 5,
            ],
            [
                'id' => 42,
                'migration' => '2022_02_06_152943_add_company_id_units',
                'batch' => 5,
            ],
            [
                'id' => 43,
                'migration' => '2022_02_06_154752_add_company_id_customers',
                'batch' => 5,
            ],
            [
                'id' => 44,
                'migration' => '2022_02_06_160446_add_company_id_business_settings',
                'batch' => 5,
            ],
            [
                'id' => 45,
                'migration' => '2022_06_19_194943_rename_columns_to_coupons_table',
                'batch' => 5,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 128,
            ],
            [
                'id' => 191,
            ],
            [
                'id' => 'json_valid(`data`',
            ],
        ];

        foreach ($data as $row) {
            DB::table('migrations')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
