<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLeadNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `lead_notes`");
        DB::statement("CREATE TABLE `lead_notes` ( `id` bigint(20) UNSIGNED NOT NULL, `lead_id` bigint(20) UNSIGNED NOT NULL, `admin_id` bigint(20) UNSIGNED NOT NULL, `note` text NOT NULL, `visibility` enum('private','team','public') NOT NULL DEFAULT 'team', `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        DB::statement("ALTER TABLE `lead_notes` ADD PRIMARY KEY (`id`), ADD KEY `idx_leadnotes_lead` (`lead_id`), ADD KEY `idx_leadnotes_admin` (`admin_id`);");
        DB::statement("ALTER TABLE `lead_notes` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("ALTER TABLE `lead_notes` ADD CONSTRAINT `fk_leadnotes_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`), ADD CONSTRAINT `fk_leadnotes_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('lead_notes');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
