<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trek;
use App\Models\PlaceType;
use App\Models\InterestingPlace;

class InterestingPlacesSeeder extends Seeder
{
    public function run(): void
    {
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\places.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $t) {
            $trek = Trek::where('regNumber', $t['regNumber'])->first();

            foreach ($t['places_of_interest'] as $p) {
                $placeType = PlaceType::firstOrCreate([
                    'name' => $p['name'],
                    'type' => $p['type'],
                    'gpsPos' => $p['gpsPos'],
                ]);

                //La relacion con el trek
                InterestingPlace::firstOrCreate([
                    'trek_id' => $trek->id,
                    'place_type_id' => $placeType->id,
                ]);
            }
        }
    }
}
