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
        $this->call(\Database\Seeders\SalesAndCustomerManagement\ApplicationStatusHistorySeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\ApprovalsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\ClientsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\ContractsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\CouponsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\CurrentOrdersSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\CurrentReserveProductsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\CustomersSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\CustomerPricesSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\CustomerProductsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\HistoryInstallmentsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\InstallmentsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\InstallmentContractsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\OrdersSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\OrderDetailsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\OrderDetailNotificationsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\OrderNotificationsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\PosSessionsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\QuotationsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\QuotationDetailsSeeder::class);
        $this->call(\Database\Seeders\SalesAndCustomerManagement\ScheduledInstallmentsSeeder::class);

    }
}
