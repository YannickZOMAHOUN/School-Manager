<?php

namespace Database\Seeders;
use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::create(['promotion' => '6ème']);
        Promotion::create(['promotion' => '5ème']);
        Promotion::create(['promotion' => '4ème']);
        Promotion::create(['promotion' => '3ème']);
        Promotion::create(['promotion' => '2nde']);
        Promotion::create(['promotion' => '1ère']);
        Promotion::create(['promotion' => 'Tle']);
    }
}
