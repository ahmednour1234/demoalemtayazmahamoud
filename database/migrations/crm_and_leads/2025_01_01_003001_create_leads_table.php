<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `leads`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `leads` -- CREATE TABLE `leads` ( `id` bigint(20) UNSIGNED NOT NULL, `owner_id` bigint(20) UNSIGNED DEFAULT NULL, `created_by_admin_id` bigint(20) UNSIGNED DEFAULT NULL, `updated_by_admin_id` bigint(20) UNSIGNED DEFAULT NULL, `status_id` bigint(20) UNSIGNED DEFAULT NULL, `source_id` bigint(20) UNSIGNED DEFAULT NULL, `company_name` varchar(190) DEFAULT NULL, `contact_name` varchar(190) DEFAULT NULL, `email` varchar(190) DEFAULT NULL, `country_code` varchar(10) DEFAULT NULL, `phone` varchar(40) DEFAULT NULL, `phone_normalized` varchar(60) GENERATED ALWAYS AS (concat(ifnull(`country_code`,''),' ',ifnull(`phone`,''))) STORED, `whatsapp` varchar(40) DEFAULT NULL, `potential_value` decimal(18,2) DEFAULT NULL, `currency` char(3) DEFAULT NULL, `rating` tinyint(4) DEFAULT NULL, `pipeline_notes` text DEFAULT NULL, `last_contact_at` datetime DEFAULT NULL, `next_action_at` datetime DEFAULT NULL, `is_archived` tinyint(1) NOT NULL DEFAULT 0, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        DB::statement("-- -- Indexes for table `leads` -- ALTER TABLE `leads` ADD PRIMARY KEY (`id`), ADD KEY `idx_leads_status` (`status_id`), ADD KEY `idx_leads_source` (`source_id`), ADD KEY `idx_leads_owner` (`owner_id`), ADD KEY `idx_leads_phone` (`phone_normalized`), ADD KEY `fk_leads_created_by` (`created_by_admin_id`), ADD KEY `fk_leads_updated_by` (`updated_by_admin_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `leads` -- ALTER TABLE `leads` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;");
        DB::statement("-- -- Constraints for table `leads` -- ALTER TABLE `leads` ADD CONSTRAINT `fk_leads_created_by` FOREIGN KEY (`created_by_admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL, ADD CONSTRAINT `fk_leads_owner` FOREIGN KEY (`owner_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL, ADD CONSTRAINT `fk_leads_source` FOREIGN KEY (`source_id`) REFERENCES `lead_sources` (`id`) ON DELETE SET NULL, ADD CONSTRAINT `fk_leads_status` FOREIGN KEY (`status_id`) REFERENCES `lead_statuses` (`id`) ON DELETE SET NULL, ADD CONSTRAINT `fk_leads_updated_by` FOREIGN KEY (`updated_by_admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL;");
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
        Schema::dropIfExists('leads');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
