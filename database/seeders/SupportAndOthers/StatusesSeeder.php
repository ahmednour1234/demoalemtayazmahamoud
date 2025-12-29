<?php

namespace Database\Seeders\SupportAndOthers;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('statuses')->truncate();
        DB::statement('INSERT INTO `statuses` (`id`, `name`, `code`, `color`, `sort_order`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, \'in_Progress\', \'in_Progress\', \'#55555\', 0, 1, NULL, \'2025-09-07 21:36:51\', \'2025-09-07 21:36:57\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
