<?php

namespace Database\Seeders\SettingsAndSystem;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('taxes')->truncate();
        DB::statement('INSERT INTO `taxes` (`id`, `name`, `amount`, `active`, `created_at`, `updated_at`) VALUES
(2, \'ضريبة القيمة المضافة\', \'15\', 1, \'2025-02-26 02:45:03\', \'2025-08-20 17:47:56\'),
(5, \'ضريبة صفريه\', \'0\', 1, \'2025-03-13 21:17:22\', \'2025-08-30 16:52:41\'),
(6, \'الضريبة الانتقائية 1\', \'100\', 1, \'2025-03-13 21:18:09\', \'2025-03-13 21:18:13\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
