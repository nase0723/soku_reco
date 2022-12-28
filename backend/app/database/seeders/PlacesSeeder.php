<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place;

class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['アトム', 'ハブ', 'ストリート'] as $value) {
            Place::create([
                'user_id' => 1,
                'name' => $value,
            ]);
        }
    }
}
