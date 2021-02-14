<?php

namespace Database\Seeders;

use App\Models\Classes;
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
        Classes::create([
            'name' => 'Kelas 10'
        ]);
        Classes::create([
            'name' => 'Kelas 11'
        ]);
        Classes::create([
            'name' => 'Kelas 12'
        ]);
    }
}
