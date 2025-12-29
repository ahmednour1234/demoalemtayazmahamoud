<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `storages`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `storages` -- CREATE TABLE `storages` ( `id` bigint(20) UNSIGNED NOT NULL, `parent_id` bigint(20) DEFAULT NULL, `local_id` bigint(20) NOT NULL, `name` varchar(255) NOT NULL, `insert_flag` tinyint(4) DEFAULT 1, `created_at` timestamp NOT NULL, `update_flag` tinyint(4) DEFAULT 0, `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `storages` -- ALTER TABLE `storages` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `storages` -- ALTER TABLE `storages` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;");
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
        Schema::dropIfExists('storages');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
