<?php

namespace Database\Seeders\FinanceAndAccounting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cost_centers')->truncate();
        DB::statement("-- -- Dumping data for table `cost_centers` -- INSERT INTO `cost_centers` (`id`, `name`, `code`, `description`, `parent_id`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'فرع حفرالباطن', '123', 'فرع حفرالباطن', 1, 1, '2025-04-28 05:19:45', '2025-09-12 11:05:17', NULL), (14, 'فرع الرياض', '1', '', 14, 1, '2025-09-11 17:20:44', '2025-09-11 17:50:25', NULL), (15, 'فرع الرياض', '1111', 'فرع الرياض', 15, 1, '2025-09-11 17:21:20', '2025-09-12 11:04:35', NULL), (16, 'فرع الرياض', '11111', '', NULL, 1, '2025-09-11 18:08:30', '2025-09-13 11:07:05', NULL), (18, 'فرع حفرالباطن', '22222', '', NULL, 1, '2025-09-13 11:06:51', '2025-09-13 11:06:51', NULL), (19, 'فرع عرعر', '33333', '', NULL, 1, '2025-09-13 11:07:21', '2025-09-13 11:07:21', NULL), (20, 'عام', '44444', '', NULL, 1, '2025-09-13 11:07:43', '2025-09-13 11:07:43', NULL), (21, 'الوكالات الرجالية', '55555', '', NULL, 1, '2025-09-13 11:08:01', '2025-09-13 11:08:01', NULL);");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
