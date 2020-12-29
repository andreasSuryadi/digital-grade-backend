<?php

namespace Database\Seeders;

use App\Models\User;
use bheller\ImagesGenerator\ImagesGeneratorProvider;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Xvladqt\Faker\LoremFlickrProvider;

class UserSeeder extends Seeder
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

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->nisn = $faker->numberBetween(100000000000, 999999999999);
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->phone_number = $faker->phoneNumber;
            if ($i == 0) {
                $user->nis = "1234567890";
                $user->email = 'admin@digitalgrade.com';
                $user->password = Hash::make('adminApp123!');
            } elseif($i == 1){
                $user->nis = "0987654321";
                $user->email = 'user@digitalgrade.com';
                $user->password = Hash::make('123123123');
            } else {
                $user->nis = $faker->numberBetween(100000000000, 999999999999);
                $user->email = $faker->email;
                $user->password = Hash::make($faker->password);
            }

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

            $path = "public/users/" . $user->id . "/profile";

            Storage::deleteDirectory($path);
            Storage::makeDirectory($path);
            $firstLetter = substr($user->first_name, 0, 1);
            $secondLetter = substr($user->last_name, 0, 1);
            $filenamePath = $faker->imageGenerator($dir = storage_path('app/public') . '/users/' . $user->id . '/profile', $width = 200, $height = 200, $format = 'png', $fullPath = false, $text = ($firstLetter.$secondLetter));

            $user->profile_picture_url = $filenamePath;

            $user->save();
        }
    }
}
