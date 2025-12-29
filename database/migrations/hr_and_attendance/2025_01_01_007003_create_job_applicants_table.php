<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateJobApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `job_applicants`");
        DB::statement("CREATE TABLE `job_applicants` ( `id` bigint(20) NOT NULL, `full_name` varchar(255) NOT NULL, `email` varchar(255) NOT NULL, `phone` varchar(50) DEFAULT NULL, `resume_pdf` varchar(255) DEFAULT NULL, `status` enum('new','screening','interview','accepted','rejected') DEFAULT 'new', `applied_date` date NOT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `job_applicants` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `job_applicants` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;");
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
        Schema::dropIfExists('job_applicants');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
