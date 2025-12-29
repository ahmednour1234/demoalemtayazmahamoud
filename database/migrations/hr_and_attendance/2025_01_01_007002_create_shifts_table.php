<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `shifts`");
        DB::statement("CREATE TABLE `shifts` ( `id` bigint(20) NOT NULL, `name` varchar(2555) NOT NULL, `start` time NOT NULL DEFAULT current_timestamp(), `end` time NOT NULL DEFAULT current_timestamp(), `breake` int(11) NOT NULL DEFAULT 1, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `kilometer` varchar(2550) NOT NULL DEFAULT '0.1', `active` int(11) NOT NULL DEFAULT 1, `max` int(11) NOT NULL DEFAULT 0, `number_shifts` int(11) NOT NULL DEFAULT 0, `hours_of_each_shift` double NOT NULL DEFAULT 0, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `shifts` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `shifts` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;");
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
        Schema::dropIfExists('shifts');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
