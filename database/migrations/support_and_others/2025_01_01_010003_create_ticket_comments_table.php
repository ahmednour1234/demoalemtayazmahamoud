<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTicketCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `ticket_comments`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `ticket_comments` -- CREATE TABLE `ticket_comments` ( `id` bigint(20) UNSIGNED NOT NULL, `ticket_id` bigint(20) UNSIGNED NOT NULL, `admin_id` bigint(20) UNSIGNED DEFAULT NULL, `body` text NOT NULL, `created_at` datetime NOT NULL DEFAULT current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `ticket_comments` -- ALTER TABLE `ticket_comments` ADD PRIMARY KEY (`id`), ADD KEY `idx_ticket` (`ticket_id`), ADD KEY `idx_admin` (`admin_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `ticket_comments` -- ALTER TABLE `ticket_comments` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("-- -- Constraints for table `ticket_comments` -- ALTER TABLE `ticket_comments` ADD CONSTRAINT `fk_tc_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('ticket_comments');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
