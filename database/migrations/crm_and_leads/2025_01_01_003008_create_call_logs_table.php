<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCallLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `call_logs`");
        DB::statement("CREATE TABLE `call_logs` ( `id` bigint(20) UNSIGNED NOT NULL, `lead_id` bigint(20) UNSIGNED NOT NULL, `admin_id` bigint(20) UNSIGNED NOT NULL, `direction` enum('inbound','outbound') NOT NULL DEFAULT 'outbound', `started_at` datetime NOT NULL, `ended_at` datetime DEFAULT NULL, `duration_sec` int(11) GENERATED ALWAYS AS (if(`ended_at` is null,NULL,timestampdiff(SECOND,`started_at`,`ended_at`))) STORED, `outcome_id` bigint(20) UNSIGNED DEFAULT NULL, `phone_used` varchar(40) DEFAULT NULL, `channel` enum('phone','whatsapp','zoom','teams','other') NOT NULL DEFAULT 'phone', `recording_url` varchar(255) DEFAULT NULL, `notes` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        DB::statement("ALTER TABLE `call_logs` ADD PRIMARY KEY (`id`), ADD KEY `idx_calllogs_lead` (`lead_id`), ADD KEY `idx_calllogs_admin` (`admin_id`), ADD KEY `idx_calllogs_outcome` (`outcome_id`), ADD KEY `idx_calllogs_time` (`started_at`);");
        DB::statement("ALTER TABLE `call_logs` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("ALTER TABLE `call_logs` ADD CONSTRAINT `fk_calllogs_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`), ADD CONSTRAINT `fk_calllogs_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE, ADD CONSTRAINT `fk_calllogs_outcome` FOREIGN KEY (`outcome_id`) REFERENCES `call_outcomes` (`id`) ON DELETE SET NULL;");
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
        Schema::dropIfExists('call_logs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
