<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductExpiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `product_expires`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `product_expires` -- CREATE TABLE `product_expires` ( `id` bigint(20) UNSIGNED NOT NULL, `product_id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) NOT NULL, `branch_id` bigint(20) NOT NULL DEFAULT 1, `quantity` varchar(20) NOT NULL, `unit` int(11) NOT NULL DEFAULT 0, `note` mediumtext DEFAULT NULL, `price` mediumtext NOT NULL DEFAULT '0', `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `product_expires` -- ALTER TABLE `product_expires` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `product_expires` -- ALTER TABLE `product_expires` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('product_expires');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
