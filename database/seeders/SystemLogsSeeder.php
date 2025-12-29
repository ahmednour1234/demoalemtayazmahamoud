<?php

namespace Database\Seeders;

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

        $data = [
            [
                'id' => 178,
                'actor_admin_id' => 161,
                'action' => 'lead_status.created',
                'table_name' => 'lead_statuses',
                'record_id' => 15,
                'lead_id' => null,
                'ip_address' => '2001:16a2:c85f:d400:527:7b76:c5ed:aba5',
                'user_agent' => ''Mozilla/5.0 (Windows NT 10.0; Win64; x64',
            ],
            [
                'id' => 'KHTML',
                'actor_admin_id' => 'like Gecko',
            ],
            [
                'id' => 179,
                'actor_admin_id' => 161,
                'action' => 'lead_status.updated',
                'table_name' => 'lead_statuses',
                'record_id' => 14,
                'lead_id' => null,
                'ip_address' => '2001:16a2:c85f:d400:527:7b76:c5ed:aba5',
                'user_agent' => ''Mozilla/5.0 (Windows NT 10.0; Win64; x64',
            ],
            [
                'id' => 'KHTML',
                'actor_admin_id' => 'like Gecko',
            ],
            [
                'id' => 186,
                'actor_admin_id' => 163,
                'action' => 'lead_source.updated',
                'table_name' => 'lead_sources',
                'record_id' => 1,
                'lead_id' => null,
                'ip_address' => '2001:16a2:c85f:d400:c0bf:7f76:aa3a:e058',
                'user_agent' => ''Mozilla/5.0 (Windows NT 10.0; Win64; x64',
            ],
            [
                'id' => 'KHTML',
                'actor_admin_id' => 'like Gecko',
            ],
            [
                'id' => 187,
                'actor_admin_id' => 163,
                'action' => 'lead_source.updated',
                'table_name' => 'lead_sources',
                'record_id' => 2,
                'lead_id' => null,
                'ip_address' => '2001:16a2:c85f:d400:c0bf:7f76:aa3a:e058',
                'user_agent' => ''Mozilla/5.0 (Windows NT 10.0; Win64; x64',
            ],
            [
                'id' => 'KHTML',
                'actor_admin_id' => 'like Gecko',
            ],
            [
                'id' => 188,
                'actor_admin_id' => 163,
                'action' => 'lead.created',
                'table_name' => 'leads',
                'record_id' => 7,
                'lead_id' => 7,
                'ip_address' => '2001:16a4:5d:eb5:14cf:27be:e034:6239',
                'user_agent' => ''Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7',
            ],
            [
                'id' => 'KHTML',
                'actor_admin_id' => 'like Gecko',
            ],
            [
                'id' => 189,
                'actor_admin_id' => 163,
                'action' => 'lead.updated',
                'table_name' => 'leads',
                'record_id' => 7,
                'lead_id' => 7,
                'ip_address' => '2001:16a4:5d:eb5:14cf:27be:e034:6239',
                'user_agent' => ''Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7',
            ],
            [
                'id' => 'KHTML',
                'actor_admin_id' => 'like Gecko',
            ],
            [
                'id' => '`id` bigint(20',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 191,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 'low',
                'actor_admin_id' => 'medium',
                'action' => 'high',
                'table_name' => 'urgent',
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 10,
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 1,
            ],
            [
                'id' => 'pending',
                'actor_admin_id' => 'approved',
                'action' => 'rejected',
            ],
            [
                'id' => 20,
            ],
            [
                'id' => 255,
            ],
            [
                'id' => 255,
            ],
        ];

        foreach ($data as $row) {
            DB::table('system_logs')->insert($row);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
