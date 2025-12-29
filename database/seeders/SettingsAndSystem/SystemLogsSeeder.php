<?php

namespace Database\Seeders\SettingsAndSystem;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('system_logs')->truncate();
        DB::statement('--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `actor_admin_id`, `action`, `table_name`, `record_id`, `lead_id`, `ip_address`, `user_agent`, `meta`, `created_at`) VALUES
(1, 100, \'department.delete\', \'departments\', 1, NULL, \'2c0f:fc88:95:2bf6:8823:94de:2f8d:415d\', \'Mozilla/5.0 (Windows NT 10.0;');
        DB::statement('INSERT INTO `system_logs` (`id`, `actor_admin_id`, `action`, `table_name`, `record_id`, `lead_id`, `ip_address`, `user_agent`, `meta`, `created_at`) VALUES
(178, 161, \'lead_status.created\', \'lead_statuses\', 15, NULL, \'2001:16a2:c85f:d400:527:7b76:c5ed:aba5\', \'Mozilla/5.0 (Windows NT 10.0;');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
