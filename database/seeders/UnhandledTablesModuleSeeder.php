<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class UnhandledTablesModuleSeeder extends Seeder {
    public function run() {
        $this->call(\Database\Seeders\UnhandledTables\SellerCustomersSeeder::class);

    }
}
