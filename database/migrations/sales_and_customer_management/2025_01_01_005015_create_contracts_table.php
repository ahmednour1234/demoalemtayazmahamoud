<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `contracts`");
        DB::statement("CREATE TABLE `contracts` ( `id` bigint(20) UNSIGNED NOT NULL, `contract_number` varchar(255) NOT NULL, `client_id` bigint(20) UNSIGNED NOT NULL, `title` varchar(255) NOT NULL, `total_value` decimal(15,2) NOT NULL, `start_date` date NOT NULL, `end_date` date DEFAULT NULL, `description` text DEFAULT NULL, `receivable_account_id` bigint(20) UNSIGNED NOT NULL, `revenue_account_id` bigint(20) UNSIGNED NOT NULL, `status` enum('draft','active','completed','canceled') NOT NULL DEFAULT 'draft', `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `contracts` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `contracts_contract_number_unique` (`contract_number`), ADD KEY `contracts_client_id_foreign` (`client_id`), ADD KEY `contracts_receivable_account_id_foreign` (`receivable_account_id`), ADD KEY `contracts_revenue_account_id_foreign` (`revenue_account_id`);");
        DB::statement("ALTER TABLE `contracts` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");
        DB::statement("ALTER TABLE `contracts` ADD CONSTRAINT `contracts_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE, ADD CONSTRAINT `contracts_receivable_account_id_foreign` FOREIGN KEY (`receivable_account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE, ADD CONSTRAINT `contracts_revenue_account_id_foreign` FOREIGN KEY (`revenue_account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('contracts');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
