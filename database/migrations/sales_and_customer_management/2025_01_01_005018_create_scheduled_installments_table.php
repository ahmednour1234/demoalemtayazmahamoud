<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateScheduledInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `scheduled_installments`");
        DB::statement("-- -------------------------------------------------------- -- -- Table structure for table `scheduled_installments` -- CREATE TABLE `scheduled_installments` ( `id` bigint(20) NOT NULL, `contract_id` bigint(20) NOT NULL, `due_date` date NOT NULL, `amount` decimal(12,2) NOT NULL, `purchased_amount` decimal(10,0) NOT NULL DEFAULT 0, `status` enum('cancelled','unpaid','partial','paid','late','pending') DEFAULT 'pending', `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("-- -- Indexes for table `scheduled_installments` -- ALTER TABLE `scheduled_installments` ADD PRIMARY KEY (`id`), ADD KEY `contract_id` (`contract_id`);");
        DB::statement("-- -- AUTO_INCREMENT for table `scheduled_installments` -- ALTER TABLE `scheduled_installments` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;");
        DB::statement("-- -- Constraints for table `scheduled_installments` -- ALTER TABLE `scheduled_installments` ADD CONSTRAINT `scheduled_installments_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `installment_contracts` (`id`) ON DELETE CASCADE;");
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
        Schema::dropIfExists('scheduled_installments');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
