<?php

namespace Database\Seeders\ProductsAndInventory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoragesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('storages')->truncate();
        DB::statement("-- -- Dumping data for table `storages` -- INSERT INTO `storages` (`id`, `parent_id`, `local_id`, `name`, `insert_flag`, `created_at`, `update_flag`, `updated_at`) VALUES (1, NULL, 1, 'الخزينة الرئيسية', 1, '2024-08-31 03:57:04', 0, '2024-09-12 15:20:22'), (22, NULL, 0, 'مستودع حفر الباطن', 1, '2024-12-08 08:34:06', 0, '2024-12-08 08:34:19'), (23, NULL, 0, 'الأصول', 1, '2025-02-27 14:56:32', 0, '2025-02-27 14:56:32'), (24, NULL, 0, 'الخصوم', 1, '2025-02-27 14:56:47', 0, '2025-02-27 14:56:47'), (25, NULL, 0, 'حقوق الملكية', 1, '2025-02-27 14:56:59', 0, '2025-02-27 14:56:59'), (26, NULL, 0, 'الإيرادات', 1, '2025-02-27 14:57:13', 0, '2025-02-27 14:57:13'), (27, NULL, 0, 'المصروفات', 1, '2025-02-27 14:57:21', 0, '2025-02-27 14:57:21'), (28, 23, 0, 'الأصول المتداولة', 1, '2025-03-03 00:45:33', 0, '2025-02-27 14:56:32'), (29, 23, 0, 'الأصول غير متداولة', 1, '2025-03-03 00:45:54', 0, '2025-02-27 14:56:32');");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
