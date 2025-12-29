<?php

namespace Database\Seeders\SettingsAndSystem;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('business_settings')->truncate();
        DB::statement('--
-- Dumping data for table `business_settings`
--

INSERT INTO `business_settings` (`id`, `key`, `value`, `created_at`, `updated_at`, `company_id`) VALUES
(1, \'shop_logo\', \'2025-09-11-68c2e9dced961.png\', NULL, NULL, 1),
(2, \'pagination_limit\', \'100000\', NULL, NULL, 1),
(3, \'currency\', \'SAR\', NULL, NULL, 1),
(4, \'shop_name\', \'شركة الامتياز للاستقدام\', NULL, NULL, 1),
(5, \'shop_address\', \'الرياض\', NULL, NULL, 1),
(6, \'shop_phone\', \'011421806\', NULL, NULL, 1),
(7, \'shop_email\', \'alemtayaz@gmail.com\', NULL, NULL, 1),
(8, \'footer_text\', \'شركة الامتياز للاستقدام\', NULL, NULL, 1),
(9, \'country\', \'AF\', NULL, NULL, 1),
(10, \'stock_limit\', \'10\', NULL, NULL, 1),
(11, \'time_zone\', \'Pacific/Midway\', NULL, NULL, 1),
(12, \'vat_reg_no\', \'302251044300003\', NULL, NULL, 1),
(13, \'kilometer\', \'0\', NULL, NULL, 1),
(14, \'number_tax\', \'302251044300003\', NULL, NULL, 1),
(15, \'color1\', \'#000000\', NULL, NULL, 1),
(16, \'color2\', \'#f2ba02\', NULL, NULL, 1),
(17, \'base_url\', \'https://testnewpos.iqbrandx.com/\', NULL, NULL, 1),
(18, \'cash\', \'1\', NULL, NULL, 1),
(19, \'shabaka\', \'1\', NULL, NULL, 1),
(20, \'agel\', \'1\', NULL, NULL, 1),
(21, \'credit\', NULL, NULL, NULL, 1),
(22, \'tax\', NULL, \'2025-02-23 17:10:02\', \'2025-02-23 17:10:02\', 1),
(23, \'opening_balance_account_id\', \'297\', \'2025-09-11 18:20:00\', \'2025-09-11 18:20:00\', 1);');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
