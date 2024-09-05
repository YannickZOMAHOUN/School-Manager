<?php

namespace Database\Seeders;
use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::create(['classroom' => '6ème']);
        Classroom::create(['classroom' => '5ème']);
        Classroom::create(['classroom' => '4ème']);
        Classroom::create(['classroom' => '3ème']);
        Classroom::create(['classroom' => '2nde']);
        Classroom::create(['classroom' => '1ère']);
        Classroom::create(['classroom' => 'Tle']);


    }
}
