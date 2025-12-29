<?php

namespace Database\Seeders\CrmAndLeads;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('leads')->truncate();
        DB::statement('INSERT INTO `leads` (`id`, `owner_id`, `created_by_admin_id`, `updated_by_admin_id`, `status_id`, `source_id`, `company_name`, `contact_name`, `email`, `country_code`, `phone`, `whatsapp`, `potential_value`, `currency`, `rating`, `pipeline_notes`, `last_contact_at`, `next_action_at`, `is_archived`, `created_at`, `updated_at`) VALUES
(7, 166, 163, NULL, 5, 2, \'Elmashreq\', \'Elmashreq\', \'Elmashreq@gmail.com\', \'+966\', \'555237602\', \'555237602\', NULL, \'SAR\', 4, \'fgffggf\', NULL, NULL, 0, \'2025-09-10 01:15:09\', \'2025-09-10 01:15:09\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
