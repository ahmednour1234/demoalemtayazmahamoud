<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateJournalEntriesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `journal_entries_details`");
        DB::statement("CREATE TABLE `journal_entries_details` ( `id` bigint(20) UNSIGNED NOT NULL, `journal_entry_id` bigint(20) UNSIGNED NOT NULL, `account_id` bigint(20) UNSIGNED NOT NULL, `debit` decimal(15,2) DEFAULT 0.00, `credit` decimal(15,2) DEFAULT 0.00, `cost_center_id` bigint(20) UNSIGNED DEFAULT NULL, `description` text DEFAULT NULL, `attachment_path` varchar(255) DEFAULT NULL, `entry_date` date NOT NULL DEFAULT current_timestamp(), `asset_id` bigint(20) DEFAULT NULL, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL, `reversal_of_detail_id` bigint(20) DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `journal_entries_details` ADD PRIMARY KEY (`id`), ADD KEY `journal_entry_id` (`journal_entry_id`);");
        DB::statement("ALTER TABLE `journal_entries_details` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;");
        DB::statement("ALTER TABLE `journal_entries_details` ADD CONSTRAINT `journal_entries_details_ibfk_1` FOREIGN KEY (`journal_entry_id`) REFERENCES `journal_entries` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('journal_entries_details');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
