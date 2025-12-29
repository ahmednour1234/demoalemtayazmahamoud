<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupportAndOthersModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\SupportAndOthers\FaqsSeeder::class);
        $this->call(\Database\Seeders\SupportAndOthers\MaintenanceLogsSeeder::class);
        $this->call(\Database\Seeders\SupportAndOthers\StatusesSeeder::class);
        $this->call(\Database\Seeders\SupportAndOthers\TicketsSeeder::class);
        $this->call(\Database\Seeders\SupportAndOthers\TicketAssigneesSeeder::class);
        $this->call(\Database\Seeders\SupportAndOthers\TicketCommentsSeeder::class);

    }
}
