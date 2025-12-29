<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `clients`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `clients` -- CREATE TABLE `clients` ( `id` bigint(20) UNSIGNED NOT NULL, `account_id` bigint(20) UNSIGNED DEFAULT NULL, `name` varchar(255) NOT NULL, `email` varchar(255) DEFAULT NULL, `phone` varchar(50) DEFAULT NULL, `address` text DEFAULT NULL, `tax_number` varchar(100) DEFAULT NULL, `company_name` varchar(255) DEFAULT NULL, `contact_person` varchar(255) DEFAULT NULL, `notes` text DEFAULT NULL, `active` tinyint(1) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT current_timestamp(), `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `clients` -- ALTER TABLE `clients` ADD PRIMARY KEY (`id`), ADD KEY `clients_account_id_foreign` (`account_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `clients` -- ALTER TABLE `clients` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;");
        DB::statement("-- -- Constraints for table `clients` -- ALTER TABLE `clients` ADD CONSTRAINT `clients_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL;");
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
        Schema::dropIfExists('clients');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
