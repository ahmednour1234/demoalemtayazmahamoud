<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `installments`");
        DB::statement("CREATE TABLE `installments` ( `id` bigint(20) UNSIGNED NOT NULL, `seller_id` bigint(20) UNSIGNED DEFAULT NULL, `customer_id` bigint(20) UNSIGNED DEFAULT NULL, `supplier_id` bigint(20) DEFAULT NULL, `branch_id` bigint(20) NOT NULL DEFAULT 1, `scheduled_installment_id` bigint(20) DEFAULT NULL, `contract_id` bigint(20) DEFAULT NULL, `total_price` int(11) NOT NULL DEFAULT 0, `note` mediumtext NOT NULL, `active` int(11) NOT NULL DEFAULT 1, `notification` int(11) NOT NULL DEFAULT 0, `insert_flag` int(11) NOT NULL DEFAULT 1, `update_flag` int(11) NOT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `img` mediumtext DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `installments` ADD PRIMARY KEY (`id`), ADD KEY `seller_id` (`seller_id`), ADD KEY `customer_id` (`customer_id`);");
        DB::statement("ALTER TABLE `installments` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
        DB::statement("ALTER TABLE `installments` ADD CONSTRAINT `installments_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
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
        Schema::dropIfExists('installments');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
