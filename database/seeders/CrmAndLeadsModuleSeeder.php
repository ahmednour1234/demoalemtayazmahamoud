<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CrmAndLeadsModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\CrmAndLeads\FollowUpsSeeder::class);
        $this->call(\Database\Seeders\CrmAndLeads\LeadsSeeder::class);
        $this->call(\Database\Seeders\CrmAndLeads\LeadSourcesSeeder::class);
        $this->call(\Database\Seeders\CrmAndLeads\LeadStatusesSeeder::class);

    }
}
