<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('leads')->truncate();

        $data = [
            [
                'id' => 7,
                'owner_id' => 166,
                'created_by_admin_id' => 163,
                'updated_by_admin_id' => null,
                'status_id' => 5,
                'source_id' => 2,
                'company_name' => 'Elmashreq',
                'contact_name' => 'Elmashreq',
                'email' => 'Elmashreq@gmail.com',
                'country_code' => '+966',
                'phone' => '555237602',
                'whatsapp' => '555237602',
                'potential_value' => null,
                'currency' => 'SAR',
                'rating' => 4,
                'pipeline_notes' => 'fgffggf',
                'last_contact_at' => null,
                'next_action_at' => null,
                'is_archived' => 0,
                'created_at' => '2025-09-10 01:15:09',
                'updated_at' => '2025-09-10 01:15:09',
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
                'id' => 190,
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
                'id' => 'private',
                'owner_id' => 'team',
                'created_by_admin_id' => 'public',
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
        ];

        foreach ($data as $row) {
            DB::table('leads')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
