<?php

namespace Database\Seeders\SettingsAndSystem;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('companies')->truncate();
        DB::statement("-- -- Dumping data for table `companies` -- INSERT INTO `companies` (`id`, `local_id`, `company_name`, `sub_domain_prefix`, `insert_flag`, `created_at`, `update_flag`, `updated_at`) VALUES (1, 1, 'Quality', '1', 1, '2024-08-29 04:52:04', 0, '2024-09-01 11:40:34');");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
