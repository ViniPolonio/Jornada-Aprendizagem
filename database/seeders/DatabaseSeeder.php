<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Aqui você registra o seeder que deseja rodar
        $this->call(MonitoringPlansSeeder::class);
    }
}
