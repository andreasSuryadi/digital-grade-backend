<?php

namespace Database\Seeders;

use App\Models\SchoolYear;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 10; $i < 20; $i++) {
            SchoolYear::create([
                'start_year' => 2000 + $i,
                'end_year' => 2000 + $i + 1,
                'semester' => 1
            ]);

            SchoolYear::create([
                'start_year' => 2000 + $i,
                'end_year' => 2000 + $i + 1,
                'semester' => 2
            ]);
        }
    }
}
