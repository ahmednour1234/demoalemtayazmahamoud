<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsAndInventoryModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\ProductsAndInventory\ArchivedProductLogsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\ArchivedStockBatchesSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\BrandsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\CategoriesSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\ConfirmStocksSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\InventoryAdjustmentsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\InventoryAdjustmentItemsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\InventoryCountsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\InventoryCountItemsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\ProductsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\ProductExpiresSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\ProductLogsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\ReserveProductsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\ReserveProductNotificationsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\StocksSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\StockBatchesSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\StockHistoriesSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\StoragesSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\StorageSellersSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\StoresSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\SubUnitsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\UnitsSeeder::class);

    }
}
