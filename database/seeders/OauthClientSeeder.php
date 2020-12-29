<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->updateOrInsert(
            [
                'id' => 2,
            ],
            [
                'name' => 'Laravel Password Grant Client',
                'secret' => 'KNuXBExRGDHOvL5uUmEy8hcxAzPuyQYP6EfQdAal',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
