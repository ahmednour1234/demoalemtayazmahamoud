<?php

namespace Database\Seeders\ProductsAndInventory;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = [
            // Sample product data structure
            // Add actual product data from the SQL file or application as needed
            // Example structure:
            /*
            [
                'id' => 1,
                'local_id' => 1,
                'name' => 'Product Name',
                'name_en' => 'Default product',
                'product_code' => 'PROD001',
                'unit_type' => 1,
                'unit_value' => 1.00,
                'brand' => null,
                'category_id' => '1',
                'purchase_price' => 100.00,
                'purchase_price1' => 100.00,
                'purchase_price2' => 0,
                'purchase_price3' => 0,
                'purchase_price4' => 0,
                'selling_price' => 150.00,
                'selling_price1' => 150.00,
                'selling_price2' => 0,
                'selling_price3' => 0,
                'selling_price4' => 0,
                'discount_type' => null,
                'discount' => null,
                'limit_stock' => 10,
                'limit_web' => 2,
                'tax' => null,
                'main_quantity' => '0',
                'quantity' => null,
                'image' => null,
                'order_count' => null,
                'refund_count' => 0,
                'purchase_count' => 0,
                'repurchase_count' => 0,
                'supplier_id' => null,
                'insert_flag' => 1,
                'created_at' => now(),
                'update_flag' => 0,
                'updated_at' => now(),
                'expiry_date' => now(),
                'company_id' => 1,
                'type' => 'product',
                'tax_id' => null,
                'branch_3' => '0',
                'branch_4' => '0',
                'branch_5' => '0',
                'branch_6' => '0',
                'branch_7' => '0',
                'product_type' => 'product',
                'branch_8' => '0',
                'branch_9' => '0',
                'branch_10' => '0',
            ],
            */
        ];

        if (!empty($products)) {
            // Insert in chunks
            foreach (array_chunk($products, 100) as $chunk) {
                DB::table('products')->insert($chunk);
            }
        }

        // Note: Add product data from the SQL file or application as needed
        // The products table structure includes: id, local_id, name, name_en, product_code, unit_type, unit_value, brand, category_id, purchase_price, selling_price, etc.
    }
}
