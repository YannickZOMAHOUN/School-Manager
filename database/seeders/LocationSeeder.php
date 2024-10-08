<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Department;
use App\Models\City;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un pays
        $country = Country::create(['name' => 'Bénin']);

        // Créer le département Alibori et ses villes
        $departmentAlibori = Department::create([
            'name' => 'Alibori',
            'country_id' => $country->id,
        ]);
        $citiesAlibori = [
            'Banikora',
            'Gogounou',
            'Kandi',
            'Karimama',
            'Malanvile',
            'Segbana',
        ];
        foreach ($citiesAlibori as $cityName) {
            City::create([
                'name' => $cityName,
                'department_id' => $departmentAlibori->id,
            ]);
        }

        // Créer le département Atacora et ses villes
        $departmentAtacora = Department::create([
            'name' => 'Atacora',
            'country_id' => $country->id,
        ]);
        $citiesAtacora = [
            'Boukoumbé',
            'Cobly',
            'Kérou',
            'Kouandé',
            'Matéri',
            'Natitingou',
            'Péhunco',
            'Tanguiéta',
            'Toucountouna',
        ];
        foreach ($citiesAtacora as $cityName) {
            City::create([
                'name' => $cityName,
                'department_id' => $departmentAtacora->id,
            ]);
        }

        // Créer le département Zou et ses villes
        $departmentZou = Department::create([
            'name' => 'Zou',
            'country_id' => $country->id,
        ]);
        $citiesZou = [
            'Abomey',
            'Agbangnizoun',
            'Bohicon',
            'Covè',
            'Djidja',
            'Ouinhi',
            'Zagnanado',
            'Za-Kpota',
            'Zogbodomey',
        ];
        foreach ($citiesZou as $cityName) {
            City::create([
                'name' => $cityName,
                'department_id' => $departmentZou->id,
            ]);
        }
    }
}
