<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Division;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $divisionIds = Division::pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            Employee::create([
                'image' => 'https://i.pravatar.cc/150?img=' . rand(1, 70),
                'name' => $faker->name,
                'phone' => $faker->unique()->phoneNumber,
                'division_id' => $faker->randomElement($divisionIds),
                'position' => $faker->jobTitle,
            ]);
        }
    }
}
