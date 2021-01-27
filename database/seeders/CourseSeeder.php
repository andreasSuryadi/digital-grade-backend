<?php

namespace Database\Seeders;

use App\Models\Course;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            Course::create([
                'code' => $faker->numberBetween(1000, 9999),
                'name' => $faker->word(),
            ]);
        }
    }
}
