<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStorageSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `storage_sellers`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `storage_sellers` -- CREATE TABLE `storage_sellers` ( `id` bigint(20) UNSIGNED NOT NULL, `storage_id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `storage_sellers` -- ALTER TABLE `storage_sellers` ADD PRIMARY KEY (`id`), ADD KEY `storage_id` (`storage_id`), ADD KEY `seller_id` (`seller_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `storage_sellers` -- ALTER TABLE `storage_sellers` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;");
        DB::statement("-- -- Constraints for table `storage_sellers` -- ALTER TABLE `storage_sellers` ADD CONSTRAINT `storage_sellers_ibfk_1` FOREIGN KEY (`storage_id`) REFERENCES `storages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `storage_sellers_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('storage_sellers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
