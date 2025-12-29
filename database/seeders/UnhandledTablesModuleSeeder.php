<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class UnhandledTablesModuleSeeder extends Seeder {
    public function run() {
        $this->call(\Database\Seeders\UnhandledTables\CourseSellersSeeder::class);
        $this->call(\Database\Seeders\UnhandledTables\DevelopSellersSeeder::class);
        $this->call(\Database\Seeders\UnhandledTables\SellerCategoriesSeeder::class);
        $this->call(\Database\Seeders\UnhandledTables\SellerCustomersSeeder::class);
        $this->call(\Database\Seeders\UnhandledTables\SellerPricesSeeder::class);
        $this->call(\Database\Seeders\UnhandledTables\SellerRegionsSeeder::class);
        $this->call(\Database\Seeders\UnhandledTables\StockOrdersSeeder::class);
        $this->call(\Database\Seeders\UnhandledTables\SuppliersSeeder::class);

    }
}
