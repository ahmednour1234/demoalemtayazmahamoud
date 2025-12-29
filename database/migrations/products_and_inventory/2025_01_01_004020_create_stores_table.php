<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `stores`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `stores` -- CREATE TABLE `stores` ( `store_id` bigint(20) NOT NULL, `local_id` bigint(20) NOT NULL, `seller_id` bigint(20) UNSIGNED DEFAULT NULL, `store_code` char(30) NOT NULL, `store_name1` varchar(100) DEFAULT NULL, `store_type` tinyint(4) DEFAULT NULL, `insert_flag` tinyint(4) DEFAULT 1, `created_at` datetime DEFAULT NULL, `update_flag` tinyint(4) DEFAULT 0, `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `company_id` bigint(20) NOT NULL DEFAULT 1, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `stores` -- ALTER TABLE `stores` ADD PRIMARY KEY (`store_id`), ADD KEY `seller_id` (`seller_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `stores` -- ALTER TABLE `stores` MODIFY `store_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;");
        DB::statement("-- -- Constraints for table `stores` -- ALTER TABLE `stores` ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('stores');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
