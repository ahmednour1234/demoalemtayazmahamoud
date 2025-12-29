<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnhandledTablesModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\UnhandledTables\SellerCustomersSeeder::class);

    }
}
