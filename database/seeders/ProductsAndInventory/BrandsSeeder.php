<?php

namespace Database\Seeders\ProductsAndInventory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('brands')->truncate();
        DB::statement('INSERT INTO `brands` (`id`, `local_id`, `name`, `image`, `insert_flag`, `created_at`, `update_flag`, `updated_at`, `company_id`) VALUES
(1, 1, \'كواليتى\', \'\', 1, \'2024-08-28 23:43:22\', 0, \'2024-09-01 11:40:32\', 1),
(2, 2, \'دايموند \', \'\', 1, \'2024-08-28 23:43:22\', 0, NULL, 1),
(3, 3, \'ساين\', \'\', 1, \'2024-08-28 23:43:22\', 0, NULL, 1),
(4, 4, \'اكسبشن\', \'\', 1, \'2024-08-28 23:49:10\', 0, NULL, 1),
(5, 5, \'مارين\', \'\', 1, \'2024-08-28 23:49:10\', 0, NULL, 1);');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
