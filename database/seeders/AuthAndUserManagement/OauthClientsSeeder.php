<?php

namespace Database\Seeders\AuthAndUserManagement;

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
        DB::statement("-- -- Dumping data for table `oauth_clients` -- INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES (1, NULL, 'Laravel Personal Access Client', 'pXnxAxPSKhx4ovCCoO44x3oKqy0opH0N7mhLApV4', NULL, 'http://localhost', 1, 0, 0, '2022-07-27 12:47:21', '2022-07-27 12:47:21'), (2, NULL, 'Laravel Password Grant Client', 'yuCn4ks9guHGCG2ZBOBa5Y7jPloMveS07BV9JKpN', 'users', 'http://localhost', 0, 1, 0, '2022-07-27 12:47:21', '2022-07-27 12:47:21');");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
