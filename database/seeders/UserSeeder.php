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

        $user = new User();
        $user->first_name = $faker->firstName;
        $user->last_name = $faker->lastName;
        $user->phone_number = $faker->phoneNumber;
        $user->email = 'admin@digitalgrade.com';
        $user->password = Hash::make('adminApp123!');
        $user->role = 'superadmin';

        $user->address = $faker->address;
        $user->blood_type = $faker->randomElement($array = ['A', 'B', 'O', 'AB']);
        $user->place_of_birth = $faker->city;
        $user->date_of_birth = $faker->dateTimeThisCentury->format('Y-m-d');

        $user->gender = "Laki-laki";

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
