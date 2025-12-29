<?php

namespace Database\Seeders\AuthAndUserManagement;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthRefreshTokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('oauth_refresh_tokens')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
