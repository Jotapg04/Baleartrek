<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trek;
use App\Models\PlaceType;
use App\Models\InterestingPlace;

class InterestingPlaceSeeder extends Seeder
{
    public function run(): void
    {
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\places.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $t) {
            $trek = Trek::where('reg_number', $t['regNumber'])->first();

            foreach ($t['places_of_interest'] as $p) {

                $placeType = PlaceType::firstOrCreate([
                    'name' => $p['type']  
                ]);

                InterestingPlace::firstOrCreate([
                    'name' => $p['name'],
                    'gps' => $p['gpsPos'],
                    'place_type_id' => $placeType->id
                ]);
            }
        }
    }
}
