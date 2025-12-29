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
        $this->call(\Database\Seeders\ProductsAndInventory\BrandsSeeder::class);
        $this->call(\Database\Seeders\ProductsAndInventory\StoragesSeeder::class);

    }
}
