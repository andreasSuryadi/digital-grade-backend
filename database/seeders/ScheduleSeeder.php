<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\SchoolYear;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $classes = Classes::all()->pluck('id');
        $course = Course::all()->pluck('id');
        $teacher = User::where('role', 'teacher')->get()->pluck('id');
        $schoolYear = SchoolYear::orderBy('id', 'DESC')->get()->take(2)->pluck('id');
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

        for ($i = 0; $i < 20; $i++) {
            Schedule::create([
                'user_id' => $faker->randomElement($teacher),
                'class_id' => $faker->randomElement($classes),
                'course_id' => $faker->randomElement($course),
                'school_year_id'  => $faker->randomElement($schoolYear),

                'day' => $faker->randomElement($days),
                'start_time' => $faker->time(),
                'end_time' => $faker->time(),
            ]);
        }
    }
}
