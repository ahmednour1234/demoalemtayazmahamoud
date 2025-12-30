<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed settings and system first (departments, branches, etc.) as other modules depend on them
        $this->call(SettingsAndSystemModuleSeeder::class);
        // Seed roles before admins
        $this->call(\Database\Seeders\AuthAndUserManagement\RolesSeeder::class);
        // Then seed admins (depends on departments and roles)
        $this->call(\Database\Seeders\AuthAndUserManagement\AdminsSeeder::class);
        // Seed remaining auth and user management
        $this->call(\Database\Seeders\AuthAndUserManagement\AdminDetailsSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\AdminSellersSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthAccessTokensSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthAuthCodesSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthClientsSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthPersonalAccessClientsSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\OauthRefreshTokensSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\PasswordResetsSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\PersonalAccessTokensSeeder::class);
        $this->call(\Database\Seeders\AuthAndUserManagement\SoftCredentialsSeeder::class);
        
        $this->call(CrmAndLeadsModuleSeeder::class);
        $this->call(ProductsAndInventoryModuleSeeder::class);
        $this->call(SalesAndCustomerManagementModuleSeeder::class);
        $this->call(FinanceAndAccountingModuleSeeder::class);
        $this->call(HrAndAttendanceModuleSeeder::class);
        $this->call(ProjectsAndTasksModuleSeeder::class);
        $this->call(ProductionAndManufacturingModuleSeeder::class);
        $this->call(SupportAndOthersModuleSeeder::class);
        $this->call(UnhandledTablesModuleSeeder::class);
    }
}
