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
        $this->call(AuthAndUserManagementModuleSeeder::class);
        $this->call(SettingsAndSystemModuleSeeder::class);
        $this->call(CrmAndLeadsModuleSeeder::class);
        $this->call(ProductsAndInventoryModuleSeeder::class);
        $this->call(SalesAndCustomerManagementModuleSeeder::class);
        $this->call(FinanceAndAccountingModuleSeeder::class);
        $this->call(HrAndAttendanceModuleSeeder::class);
        $this->call(ProjectsAndTasksModuleSeeder::class);
        $this->call(SupportAndOthersModuleSeeder::class);
        $this->call(UnhandledTablesModuleSeeder::class);
    }
}
