<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalesAndCustomerManagementModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\SalesAndCustomerManagement\CustomersSeeder::class);

    }
}
