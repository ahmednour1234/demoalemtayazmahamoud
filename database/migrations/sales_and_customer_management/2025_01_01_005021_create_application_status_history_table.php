<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateApplicationStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `application_status_history`");
        DB::statement("CREATE TABLE `application_status_history` ( `id` int(11) NOT NULL, `job_applicant_id` int(11) NOT NULL, `previous_status` varchar(50) NOT NULL, `new_status` varchar(50) NOT NULL, `changed_at` timestamp NULL DEFAULT current_timestamp(), `comment` text DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `application_status_history` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `application_status_history` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;");
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
        Schema::dropIfExists('application_status_history');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
