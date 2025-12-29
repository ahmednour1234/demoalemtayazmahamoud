<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('lead_sources')->truncate();

        $data = [
            [
                'id' => 1,
                'name' => 'فيس بوك',
                'code' => '1234',
                'created_at' => '2025-08-23 03:36:01',
                'updated_at' => '2025-09-09 18:18:16',
            ],
            [
                'id' => 2,
                'name' => 'انستجرام',
                'code' => '12345',
                'created_at' => '2025-08-23 03:40:35',
                'updated_at' => '2025-09-09 18:18:26',
            ],
            [
                'id' => 3,
                'name' => 'تيك توك',
                'code' => '1221',
                'created_at' => '2025-08-23 14:43:54',
                'updated_at' => '2025-08-23 14:43:54',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 100,
            ],
            [
                'id' => 50,
            ],
            [
                'id' => 11,
            ],
            [
                'id' => 1,
            ],
        ];

        foreach ($data as $row) {
            DB::table('lead_sources')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
