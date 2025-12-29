<?php

namespace Database\Seeders;

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

        $data = [
            [
                'id' => 1,
                'name' => 'فرع الرياض الفرع الرئيسي',
                'lang' => '0',
                'code' => '1',
                'account_stock_Id' => 16,
                'lat' => '0',
                'active' => 1,
                'created_at' => '2025-02-21 04:09:29',
                'updated_at' => '2025-09-09 17:25:33',
            ],
            [
                'id' => 9,
                'name' => 'فرع حفر الباطن',
                'lang' => '0',
                'code' => '2',
                'account_stock_Id' => 153,
                'lat' => '0',
                'active' => 1,
                'created_at' => '2025-09-09 17:24:13',
                'updated_at' => '2025-09-09 17:26:12',
            ],
            [
                'id' => 10,
                'name' => 'فرع عرعر',
                'lang' => null,
                'code' => '3',
                'account_stock_Id' => 154,
                'lat' => null,
                'active' => 1,
                'created_at' => '2025-09-09 17:26:39',
                'updated_at' => '2025-09-09 17:26:39',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 4,
            ],
            [
                'id' => 4,
            ],
            [
                'id' => 20,
            ],
        ];

        foreach ($data as $row) {
            DB::table('branches')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
