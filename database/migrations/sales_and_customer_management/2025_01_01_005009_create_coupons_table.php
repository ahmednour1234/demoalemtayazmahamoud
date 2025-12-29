<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement("DROP TABLE IF EXISTS `coupons`");
        DB::statement("CREATE TABLE `coupons` ( `id` bigint(20) UNSIGNED NOT NULL, `title` varchar(100) DEFAULT NULL, `coupon_type` varchar(255) NOT NULL DEFAULT 'default', `user_limit` int(11) DEFAULT NULL, `code` varchar(255) DEFAULT NULL, `start_date` date DEFAULT NULL, `expire_date` date DEFAULT NULL, `min_purchase` decimal(8,2) NOT NULL DEFAULT 0.00, `max_discount` decimal(8,2) NOT NULL DEFAULT 0.00, `discount` decimal(8,2) NOT NULL DEFAULT 0.00, `discount_type` varchar(15) NOT NULL DEFAULT 'percentage', `status` tinyint(1) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `company_id` bigint(20) DEFAULT 1, `deleted_at` timestamp NULL DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        DB::statement("ALTER TABLE `coupons` ADD PRIMARY KEY (`id`);");
        DB::statement("ALTER TABLE `coupons` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
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
        Schema::dropIfExists('coupons');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
