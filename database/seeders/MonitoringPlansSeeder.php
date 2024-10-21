<?php

namespace Database\Seeders;

use App\Models\MonitoringPlans;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MonitoringPlansSeeder extends Seeder
{
    public function run()
    {
        //Criando dados fake para simulação
        $faker = Faker::create();
        $id_plant = 1;

        foreach (range(1, 500) as $index) {
            MonitoringPlans::create([
                'id_plant'   => $id_plant,
                'temperatura' => $faker->numberBetween(20, 35),  // Temperatura entre 20ºC e 35ºC
                'umidade'     => $faker->numberBetween(40, 90),  // Umidade entre 40% e 90%
                'created_at'  => $faker->dateTimeThisYear(),
                'updated_at'  => now(),
            ]);
        }
    }
}
