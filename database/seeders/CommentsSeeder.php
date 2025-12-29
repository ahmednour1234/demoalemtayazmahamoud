<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('comments')->truncate();

        $data = [
            [
                'id' => 1,
                'entity_type' => 'task',
                'entity_id' => 2,
                'admin_id' => 100,
                'body' => 'wwqewq',
                'deleted_at' => null,
                'created_at' => '2025-09-07 23:07:24',
                'updated_at' => '2025-09-07 23:07:24',
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
        ];

        foreach ($data as $row) {
            DB::table('comments')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
