<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matter;
use Illuminate\Support\Str;

class MatterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 4; $i++) {
            Matter::create([
                'name' => Str::random(4),
                'place_id' => $i,
                'user_id' => 1,
                'street_value' => $i,
                'age' => 21,
                'work' => Str::random(4),
            ]);
        }
    }
}
