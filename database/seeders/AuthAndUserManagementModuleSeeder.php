<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AuthAndUserManagementModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\AuthAndUserManagement\AdminsSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\AdminDetailsSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\AdminSellersSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthAccessTokensSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthAuthCodesSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthClientsSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthPersonalAccessClientsSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthRefreshTokensSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\PasswordResetsSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\PersonalAccessTokensSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\RolesSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\SoftCredentialsSeeder::class);

    }
}
