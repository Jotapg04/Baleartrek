<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlaceType;
use App\Models\InterestingPlace;
use App\Models\Trek;

class PlacesSeeder extends Seeder
{
    public function run(): void
    {
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\places.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $t) {
            $regNumber = $t['regNumber'];
            $trek = Trek::where('regNumber', $regNumber)->first();

            foreach ($t['places_of_interest'] as $p) {
                $placeType = PlaceType::firstOrCreate([
                    'name' => $p['name'],
                    'type' => $p['type'],
                    'gpsPos' => $p['gpsPos']
                ]);

                // Crear la relación con el trek
                $interestingPlace = new InterestingPlace();
                $interestingPlace->trek_id = $trek->id;
                $interestingPlace->place_type_id = $placeType->id;
                $interestingPlace->save();
            }
        }
    }
}
