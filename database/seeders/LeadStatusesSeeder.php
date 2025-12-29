<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('lead_statuses')->truncate();

        $data = [
            [
                'id' => 5,
                'name' => 'اصدار العقد',
                'code' => '1',
                'sort_order' => 100,
                'is_active' => 1,
                'created_at' => '2025-09-09 17:57:24',
                'updated_at' => '2025-09-09 17:57:24',
            ],
            [
                'id' => 6,
                'name' => 'انتظار موافقة مكتب الارسال الخارجي',
                'code' => '2',
                'sort_order' => 101,
                'is_active' => 1,
                'created_at' => '2025-09-09 17:59:17',
                'updated_at' => '2025-09-09 17:59:17',
            ],
            [
                'id' => 7,
                'name' => 'انتظار نتيجة الفحص الطبي',
                'code' => '3',
                'sort_order' => 102,
                'is_active' => 1,
                'created_at' => '2025-09-09 17:59:43',
                'updated_at' => '2025-09-09 17:59:43',
            ],
            [
                'id' => 8,
                'name' => 'انتظار موافقة وزارة العمل الخارجيه',
                'code' => '104',
                'sort_order' => 103,
                'is_active' => 1,
                'created_at' => '2025-09-09 18:00:11',
                'updated_at' => '2025-09-09 18:00:11',
            ],
            [
                'id' => 9,
                'name' => 'تصديق التاشيره',
                'code' => '105',
                'sort_order' => 104,
                'is_active' => 1,
                'created_at' => '2025-09-09 18:01:13',
                'updated_at' => '2025-09-09 18:01:13',
            ],
            [
                'id' => 10,
                'name' => 'انتظار الحصول علي شهادة التدريب المدرسي',
                'code' => '106',
                'sort_order' => 105,
                'is_active' => 1,
                'created_at' => '2025-09-09 18:02:42',
                'updated_at' => '2025-09-09 18:02:42',
            ],
            [
                'id' => 11,
                'name' => 'الحصول علي ورقة حسن السير والسلوك',
                'code' => '107',
                'sort_order' => 106,
                'is_active' => 1,
                'created_at' => '2025-09-09 18:03:20',
                'updated_at' => '2025-09-09 18:03:20',
            ],
            [
                'id' => 12,
                'name' => 'تم اصدار التاشيره',
                'code' => '108',
                'sort_order' => 109,
                'is_active' => 1,
                'created_at' => '2025-09-09 18:04:32',
                'updated_at' => '2025-09-09 18:04:32',
            ],
            [
                'id' => 13,
                'name' => 'الصحول علي تصريح السفر',
                'code' => '109',
                'sort_order' => 108,
                'is_active' => 1,
                'created_at' => '2025-09-09 18:05:03',
                'updated_at' => '2025-09-09 18:05:03',
            ],
            [
                'id' => 14,
                'name' => 'انتظار حجز التذكره',
                'code' => '110',
                'sort_order' => 109,
                'is_active' => 1,
                'created_at' => '2025-09-09 18:05:20',
                'updated_at' => '2025-09-09 18:08:04',
            ],
            [
                'id' => 15,
                'name' => 'موعد الوصول',
                'code' => '111',
                'sort_order' => 110,
                'is_active' => 1,
                'created_at' => '2025-09-09 18:06:32',
                'updated_at' => '2025-09-09 18:06:32',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 190,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'pending',
                'name' => 'done',
                'code' => 'canceled',
            ],
            [
                'id' => 'low',
                'name' => 'normal',
                'code' => 'high',
                'sort_order' => 'urgent',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'preventive',
                'name' => 'emergency',
            ],
            [
                'id' => 12,
                'name' => 2,
            ],
            [
                'id' => 'scheduled',
                'name' => 'in progress',
                'code' => 'completed',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => '`id` int(10',
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 11,
            ],
        ];

        foreach ($data as $row) {
            DB::table('lead_statuses')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
