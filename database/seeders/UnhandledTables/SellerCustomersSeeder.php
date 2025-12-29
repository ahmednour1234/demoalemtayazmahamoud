<?php

namespace Database\Seeders\UnhandledTables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerCustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('seller_customers')->truncate();
        DB::statement('INSERT INTO `seller_customers` (`id`, `local_id`, `customer_id`, `seller_id`, `created_at`, `updated_at`) VALUES
(5782, 0, 15, 163, \'2025-09-29 15:50:11\', \'2025-09-29 15:50:11\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
