<?php

namespace Database\Seeders\CrmAndLeads;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('lead_sources')->truncate();
        DB::statement('--
-- Dumping data for table `lead_sources`
--

INSERT INTO `lead_sources` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, \'فيس بوك\', \'1234\', \'2025-08-23 03:36:01\', \'2025-09-09 18:18:16\'),
(2, \'انستجرام\', \'12345\', \'2025-08-23 03:40:35\', \'2025-09-09 18:18:26\'),
(3, \'تيك توك\', \'1221\', \'2025-08-23 14:43:54\', \'2025-08-23 14:43:54\');');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
