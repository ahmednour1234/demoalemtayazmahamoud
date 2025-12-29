<?php

namespace Database\Seeders;

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

        $data = [
            [
                'id' => 2,
                'name' => 'ضريبة القيمة المضافة',
                'amount' => '15',
                'active' => 1,
                'created_at' => '2025-02-26 02:45:03',
                'updated_at' => '2025-08-20 17:47:56',
            ],
            [
                'id' => 5,
                'name' => 'ضريبة صفريه',
                'amount' => '0',
                'active' => 1,
                'created_at' => '2025-03-13 21:17:22',
                'updated_at' => '2025-08-30 16:52:41',
            ],
            [
                'id' => 6,
                'name' => 'الضريبة الانتقائية 1',
                'amount' => '100',
                'active' => 1,
                'created_at' => '2025-03-13 21:18:09',
                'updated_at' => '2025-03-13 21:18:13',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 50,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 'pending',
                'name' => 'approved',
                'amount' => 'rejected',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 20,
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
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
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
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 255,
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
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
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
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 500,
            ],
            [
                'id' => 500,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
        ];

        foreach ($data as $row) {
            DB::table('taxes')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
