<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTicketAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `ticket_assignees`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `ticket_assignees` -- CREATE TABLE `ticket_assignees` ( `id` bigint(20) UNSIGNED NOT NULL, `ticket_id` bigint(20) UNSIGNED NOT NULL, `admin_id` bigint(20) UNSIGNED NOT NULL, `assigned_by_admin_id` bigint(20) UNSIGNED DEFAULT NULL, `is_active` tinyint(1) NOT NULL DEFAULT 1, `assigned_at` datetime NOT NULL DEFAULT current_timestamp(), `unassigned_at` datetime DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `ticket_assignees` -- ALTER TABLE `ticket_assignees` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uq_ticket_admin_once` (`ticket_id`,`admin_id`,`is_active`), ADD KEY `idx_ticket_active` (`ticket_id`,`is_active`), ADD KEY `idx_admin` (`admin_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `ticket_assignees` -- ALTER TABLE `ticket_assignees` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("-- -- Constraints for table `ticket_assignees` -- ALTER TABLE `ticket_assignees` ADD CONSTRAINT `fk_ta_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('ticket_assignees');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
