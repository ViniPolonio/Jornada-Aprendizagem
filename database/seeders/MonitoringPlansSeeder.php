<?php

namespace Database\Seeders;

use App\Models\MonitoringPlans;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MonitoringPlansSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $id_plant = 2;

        foreach (range(1, 50) as $index) {
            MonitoringPlans::create([
                'id_plant'   => $id_plant,
                'temperatura' => $faker->numberBetween(20, 35),  
                'umidade'     => $faker->numberBetween(40, 90),  
            
                'created_at'  => $faker->dateTimeBetween('-20 days', 'now'),
                'updated_at'  => now(),
            ]);
        }
    }
}
