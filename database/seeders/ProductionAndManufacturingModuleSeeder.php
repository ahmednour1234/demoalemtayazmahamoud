<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductionAndManufacturingModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\ProductionAndManufacturing\BillsOfMaterialsSeeder::class);
        $this->call(\Database\Seeders\ProductionAndManufacturing\BomComponentsSeeder::class);
        $this->call(\Database\Seeders\ProductionAndManufacturing\ProductionOrdersSeeder::class);
        $this->call(\Database\Seeders\ProductionAndManufacturing\ProductionOrderBatchesSeeder::class);
        $this->call(\Database\Seeders\ProductionAndManufacturing\ProductionOrderExecutionsSeeder::class);
        $this->call(\Database\Seeders\ProductionAndManufacturing\ProductionOrderExecutionItemsSeeder::class);
        $this->call(\Database\Seeders\ProductionAndManufacturing\ProductionOrderLogsSeeder::class);
        $this->call(\Database\Seeders\ProductionAndManufacturing\RoutingsSeeder::class);
        $this->call(\Database\Seeders\ProductionAndManufacturing\RoutingOperationsSeeder::class);
        $this->call(\Database\Seeders\ProductionAndManufacturing\WorkCentersSeeder::class);

    }
}
