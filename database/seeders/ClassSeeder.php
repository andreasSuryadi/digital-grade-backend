<?php

namespace Database\Seeders;

use App\Models\Classes;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
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
            Classes::create([
                'name' => $faker->word()
            ]);
        }
    }
}
