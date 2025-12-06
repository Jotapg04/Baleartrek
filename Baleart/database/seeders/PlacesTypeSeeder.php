<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlaceType;

class PlacesTypeSeeder extends Seeder
{
    public function run(): void
    {
    
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\places.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $t) {
            foreach ($t['places_of_interest'] as $p) {
                PlaceType::firstOrCreate([
                    'name' => $p['type']
                ]);
            }
        }
    }
}

