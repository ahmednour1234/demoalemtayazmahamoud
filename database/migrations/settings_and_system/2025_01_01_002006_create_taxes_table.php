<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `taxes`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `taxes` -- CREATE TABLE `taxes` ( `id` bigint(20) UNSIGNED NOT NULL, `name` varchar(25) NOT NULL, `amount` varchar(11) NOT NULL, `active` int(11) NOT NULL DEFAULT 0, `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `taxes` -- ALTER TABLE `taxes` ADD PRIMARY KEY (`id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `taxes` -- ALTER TABLE `taxes` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;");
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
        Schema::dropIfExists('taxes');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
