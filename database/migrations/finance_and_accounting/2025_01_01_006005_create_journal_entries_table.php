<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateJournalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `journal_entries`");
        DB::statement("CREATE TABLE `journal_entries` ( `id` bigint(20) UNSIGNED NOT NULL, `entry_date` date NOT NULL, `reference` varchar(100) DEFAULT NULL, `description` text DEFAULT NULL, `created_by` bigint(20) UNSIGNED DEFAULT NULL, `payment_voucher_id` bigint(20) UNSIGNED DEFAULT NULL, `type` varchar(255) NOT NULL DEFAULT 'entry', `branch_id` bigint(20) NOT NULL DEFAULT 1, `asset_id` bigint(20) DEFAULT NULL, `reversal` int(11) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL, `reversal_of_id` bigint(20) DEFAULT NULL, `head_date` timestamp NOT NULL DEFAULT current_timestamp(), `ref` bigint(20) DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `journal_entries` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `journal_entries` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;");
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
        Schema::dropIfExists('journal_entries');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
