<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInterviewEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `interview_evaluations`");
        DB::statement("CREATE TABLE `interview_evaluations` ( `id` int(11) NOT NULL, `job_applicant_id` bigint(20) NOT NULL, `interviewer` varchar(255) NOT NULL, `interview_date` date NOT NULL, `evaluation_notes` text DEFAULT NULL, `score` int(11) DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `interview_evaluations` ADD PRIMARY KEY (`id`), ADD KEY `job_applicant_id` (`job_applicant_id`);");
        DB::statement("ALTER TABLE `interview_evaluations` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
        DB::statement("ALTER TABLE `interview_evaluations` ADD CONSTRAINT `interview_evaluations_ibfk_1` FOREIGN KEY (`job_applicant_id`) REFERENCES `job_applicants` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('interview_evaluations');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
