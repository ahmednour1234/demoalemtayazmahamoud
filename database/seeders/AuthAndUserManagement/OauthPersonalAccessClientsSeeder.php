<?php

namespace Database\Seeders\AuthAndUserManagement;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthPersonalAccessClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('oauth_personal_access_clients')->truncate();
        DB::statement('INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, \'2022-07-27 12:47:21\', \'2022-07-27 12:47:21\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
