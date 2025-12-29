<?php

namespace Database\Seeders\AuthAndUserManagement;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('admin_sellers')->truncate();
        DB::statement('INSERT INTO `admin_sellers` (`id`, `admin_id`, `seller_id`, `created_at`, `updated_at`) VALUES
(70, 162, 100, \'2025-08-30 15:32:43\', \'2025-08-30 15:32:43\'),
(71, 162, 159, \'2025-08-30 15:32:43\', \'2025-08-30 15:32:43\'),
(72, 162, 160, \'2025-08-30 15:32:43\', \'2025-08-30 15:32:43\'),
(73, 162, 161, \'2025-08-30 15:32:43\', \'2025-08-30 15:32:43\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
