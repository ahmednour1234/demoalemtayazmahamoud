<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `attendances`");
        DB::statement("CREATE TABLE `attendances` ( `id` bigint(20) NOT NULL, `admin_id` bigint(20) NOT NULL, `date` date NOT NULL, `check_in` time NOT NULL, `check_out` time DEFAULT NULL, `status` int(11) NOT NULL DEFAULT 1, `time_late` varchar(255) NOT NULL DEFAULT '0', `expected_hours` varchar(255) NOT NULL DEFAULT '0', `worked_hours` varchar(255) NOT NULL DEFAULT '0', `created_at` timestamp NOT NULL DEFAULT current_timestamp(), `updated_at` timestamp NOT NULL DEFAULT current_timestamp(), `lang` double DEFAULT NULL, `late` double DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `attendances` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `attendances` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('attendances');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
