<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSellerRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `seller_regions`");
        DB::statement("CREATE TABLE `seller_regions` ( `id` int(11) NOT NULL, `seller_id` bigint(20) UNSIGNED NOT NULL, `region_id` bigint(20) UNSIGNED NOT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;");
        DB::statement("ALTER TABLE `seller_regions` ADD PRIMARY KEY (`id`), ADD KEY `region_id` (`region_id`), ADD KEY `seller_regions_ibfk_1` (`seller_id`);");
        DB::statement("ALTER TABLE `seller_regions` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;");
        DB::statement("ALTER TABLE `seller_regions` ADD CONSTRAINT `seller_regions_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `seller_regions_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('seller_regions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
