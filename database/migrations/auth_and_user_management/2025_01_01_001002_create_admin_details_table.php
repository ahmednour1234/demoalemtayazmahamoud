<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAdminDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `admin_details`");
        DB::statement("CREATE TABLE `admin_details` ( `id` bigint(20) NOT NULL, `admin_id` bigint(20) DEFAULT NULL, `full_name` varchar(255) NOT NULL, `email` varchar(255) DEFAULT NULL, `phone` varchar(50) DEFAULT NULL, `department` varchar(100) DEFAULT NULL, `job_title` varchar(100) DEFAULT NULL, `hire_date` date DEFAULT NULL, `qualifications` text DEFAULT NULL, `contract_details` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `admin_details` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `admin_details` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;");
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
        Schema::dropIfExists('admin_details');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
