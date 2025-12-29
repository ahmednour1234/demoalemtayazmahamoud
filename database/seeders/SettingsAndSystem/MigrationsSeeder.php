<?php

namespace Database\Seeders\SettingsAndSystem;

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
        DB::statement('INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, \'2014_10_12_000000_create_users_table\', 1),
(2, \'2014_10_12_100000_create_password_resets_table\', 1),
(3, \'2019_08_19_000000_create_failed_jobs_table\', 1),
(4, \'2019_12_14_000001_create_personal_access_tokens_table\', 1),
(5, \'2021_11_02_095022_create_business_settings_table\', 1),
(6, \'2021_11_02_114801_create_admins_table\', 1),
(7, \'2021_11_03_044923_create_categories_table\', 1),
(8, \'2021_11_03_090927_create_brands_table\', 1),
(9, \'2021_11_03_101237_create_products_table\', 1),
(10, \'2021_11_06_025604_create_currencies_table\', 1),
(11, \'2021_11_06_031804_create_orders_table\', 1),
(12, \'2021_11_06_084528_create_order_details_table\', 1),
(13, \'2021_11_08_094042_create_customers_table\', 1),
(15, \'2021_11_11_051704_create_coupons_table\', 1),
(16, \'2021_11_13_100539_create_units_table\', 1),
(17, \'2021_11_17_034203_create_accounts_table\', 1),
(20, \'2021_11_17_083502_create_transections_table\', 2),
(21, \'2021_11_09_064445_create_suppliers_table\', 3),
(22, \'2021_06_17_054551_create_soft_credentials_table\', 4),
(23, \'2021_12_01_141901_add_phone_col_admin\', 4),
(24, \'2021_12_02_092539_add_image_to_admin_tables\', 4),
(25, \'2016_06_01_000001_create_oauth_auth_codes_table\', 5),
(26, \'2016_06_01_000002_create_oauth_access_tokens_table\', 5),
(27, \'2016_06_01_000003_create_oauth_refresh_tokens_table\', 5),
(28, \'2016_06_01_000004_create_oauth_clients_table\', 5),
(29, \'2016_06_01_000005_create_oauth_personal_access_clients_table\', 5),
(30, \'2022_02_06_115834_create_companies_table\', 5),
(31, \'2022_02_06_121739_add_company_id_col_admin\', 5),
(32, \'2022_02_06_150041_add_company_id_category\', 5),
(33, \'2022_02_06_151731_add_company_id_brand\', 5),
(34, \'2022_02_06_152243_add_company_id_accounts\', 5),
(35, \'2022_02_06_152301_add_company_id_coupon\', 5),
(36, \'2022_02_06_152323_add_company_id_users\', 5),
(37, \'2022_02_06_152357_add_company_id_orders\', 5),
(38, \'2022_02_06_152412_add_company_id_order_details\', 5),
(39, \'2022_02_06_152429_add_company_id_products\', 5),
(40, \'2022_02_06_152453_add_company_id_suppliers\', 5),
(41, \'2022_02_06_152515_add_company_id_transactions\', 5),
(42, \'2022_02_06_152943_add_company_id_units\', 5),
(43, \'2022_02_06_154752_add_company_id_customers\', 5),
(44, \'2022_02_06_160446_add_company_id_business_settings\', 5),
(45, \'2022_06_19_194943_rename_columns_to_coupons_table\', 5);');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
