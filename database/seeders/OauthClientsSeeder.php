<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('oauth_clients')->truncate();

        $data = [
            [
                'id' => 1,
                'user_id' => null,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'pXnxAxPSKhx4ovCCoO44x3oKqy0opH0N7mhLApV4',
                'provider' => null,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2022-07-27 12:47:21',
                'updated_at' => '2022-07-27 12:47:21',
            ],
            [
                'id' => 2,
                'user_id' => null,
                'name' => 'Laravel Password Grant Client',
                'secret' => 'yuCn4ks9guHGCG2ZBOBa5Y7jPloMveS07BV9JKpN',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2022-07-27 12:47:21',
                'updated_at' => '2022-07-27 12:47:21',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
        ];

        foreach ($data as $row) {
            DB::table('oauth_clients')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
