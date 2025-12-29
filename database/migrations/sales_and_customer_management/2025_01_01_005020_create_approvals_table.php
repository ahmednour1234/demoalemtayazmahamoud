<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `approvals`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `approvals` -- CREATE TABLE `approvals` ( `id` bigint(20) UNSIGNED NOT NULL, `approvable_type` enum('task','project','lead') NOT NULL, `approvable_id` bigint(20) UNSIGNED NOT NULL, `requested_by` bigint(20) UNSIGNED NOT NULL, `approver_id` bigint(20) UNSIGNED NOT NULL, `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending', `reason` varchar(255) DEFAULT NULL, `next_step_hint` varchar(255) DEFAULT NULL, `decided_at` datetime DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `approvals` -- ALTER TABLE `approvals` ADD PRIMARY KEY (`id`), ADD KEY `fk_approvals_requester` (`requested_by`), ADD KEY `fk_approvals_approver` (`approver_id`), ADD KEY `idx_approvals_target` (`approvable_type`,`approvable_id`), ADD KEY `idx_approvals_status` (`status`);");
        DB::statement("-- -- AUTO_INCREMENT for table `approvals` -- ALTER TABLE `approvals` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("-- -- Constraints for table `approvals` -- ALTER TABLE `approvals` ADD CONSTRAINT `fk_approvals_approver` FOREIGN KEY (`approver_id`) REFERENCES `admins` (`id`), ADD CONSTRAINT `fk_approvals_requester` FOREIGN KEY (`requested_by`) REFERENCES `admins` (`id`);");
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
        Schema::dropIfExists('approvals');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
