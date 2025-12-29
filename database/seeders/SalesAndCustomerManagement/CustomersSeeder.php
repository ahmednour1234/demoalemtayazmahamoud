<?php

namespace Database\Seeders\SalesAndCustomerManagement;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('customers')->truncate();
        DB::statement("-- -- Dumping data for table `customers` -- INSERT INTO `customers` (`id`, `local_id`, `name`, `name_en`, `mobile`, `email`, `image`, `state`, `city`, `zip_code`, `address`, `balance`, `credit`, `type`, `latitude`, `longitude`, `active`, `limit`, `insert_flag`, `created_at`, `update_flag`, `updated_at`, `company_id`, `category_id`, `specialist`, `region_id`, `pharmacy_name`, `tax_number`, `c_history`, `discount`, `account_id`, `guarantor_id`) VALUES (1, 0, 'الكاشير', 'Default Customer', '1', NULL, NULL, NULL, NULL, NULL, NULL, 1235.938, 7450.6944117147, 0, NULL, NULL, 1, 0, 1, NULL, 0, '2025-08-15 04:24:53', 1, NULL, 1, 1, NULL, '0', '0', 0, 92, NULL), (15, 0, 'سالم فهد عبدالخالق الزهراني', NULL, '0568708838', 'alemtayaz@gmail.com', 'def.png', '1', 'الرياض', '12244', 'الأمير فيصل بن سعد بن عبدالرحمن', NULL, 0, 1, '30.0444', '31.2357', 1, 0, 1, '2025-09-29 18:50:11', 0, '2025-09-29 18:52:31', 1, NULL, 1, 0, NULL, '1', '1', 0, 363, NULL);");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
