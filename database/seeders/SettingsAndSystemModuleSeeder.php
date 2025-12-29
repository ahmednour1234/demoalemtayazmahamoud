<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsAndSystemModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\SettingsAndSystem\BranchesSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\BusinessSettingsSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\CompaniesSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\CurrenciesSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\CustomFieldsSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\CustomFieldValuesSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\DepartmentsSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\MigrationsSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\NotificationsSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\RegionsSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\SystemLogsSeeder::class);
        $this->call(\Database\Seeders\SettingsAndSystem\TaxesSeeder::class);

    }
}
