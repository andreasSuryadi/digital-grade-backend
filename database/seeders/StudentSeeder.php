<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\ClassesUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use bheller\ImagesGenerator\ImagesGeneratorProvider;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Xvladqt\Faker\LoremFlickrProvider;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $faker->addProvider(new LoremFlickrProvider($faker));
        $faker->addProvider(new ImagesGeneratorProvider($faker));

        $classes = Classes::all()->pluck('id');

        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->phone_number = $faker->phoneNumber;
            if ($i == 0) {
                $user->nisn = "0987654321";
                $user->nis = "4858984599";
                $user->email = 'student@digitalgrade.com';
                $user->password = Hash::make('123123123');
            } else {
                $user->nisn = $faker->numberBetween(100000000000, 999999999999);
                $user->nis = $faker->numberBetween(100000000000, 999999999999);
                $user->email = $faker->email;
                $user->password = Hash::make($faker->password);
            }
            
            $user->role = 'student';
            $user->address = $faker->address;
            $user->blood_type = $faker->randomElement($array = ['A', 'B', 'O', 'AB']);
            $user->place_of_birth = $faker->city;
            $user->date_of_birth = $faker->dateTimeThisCentury->format('Y-m-d');

            if($i%2 == 0){
                $user->gender = "Laki-laki";
            }else{
                $user->gender = "Perempuan";
            }

            $user->remember_token = $faker->boolean;

            $user->save();

            $path = "public/users/" . $user->id . "/profile";

            Storage::deleteDirectory($path);
            Storage::makeDirectory($path);
            $firstLetter = substr($user->first_name, 0, 1);
            $secondLetter = substr($user->last_name, 0, 1);
            $filenamePath = $faker->imageGenerator($dir = storage_path('app/public') . '/users/' . $user->id . '/profile', $width = 200, $height = 200, $format = 'png', $fullPath = false, $text = ($firstLetter.$secondLetter));

            $user->profile_picture_url = $filenamePath;

            $user->save();

            ClassesUser::create([
                'user_id' => $user->id,
                'classes_id' => $faker->randomElement($classes)
            ]);
        }
    }
}
