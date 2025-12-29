<?php

namespace Database\Seeders\SettingsAndSystem;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('branches')->truncate();
        DB::statement('INSERT INTO `branches` (`id`, `name`, `lang`, `code`, `account_stock_Id`, `lat`, `active`, `created_at`, `updated_at`) VALUES
(1, \'فرع الرياض الفرع الرئيسي\', \'0\', \'1\', 16, \'0\', 1, \'2025-02-21 04:09:29\', \'2025-09-09 17:25:33\'),
(9, \'فرع حفر الباطن\', \'0\', \'2\', 153, \'0\', 1, \'2025-09-09 17:24:13\', \'2025-09-09 17:26:12\'),
(10, \'فرع عرعر\', NULL, \'3\', 154, NULL, 1, \'2025-09-09 17:26:39\', \'2025-09-09 17:26:39\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
