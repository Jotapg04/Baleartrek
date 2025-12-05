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
            // Buscar el trek por reg_number correcto
            $reg_number = $t['regNumber'];
            $trek = Trek::where('reg_number', $reg_number)->first()->id;

            foreach ($t['places_of_interest'] as $p) {
                
                $placeType = PlaceType::firstOrCreate([
                    'name' => $p['type']
                ]);

                // Evitar duplicados en interesting_places por GPS
                $interestingPlace = InterestingPlace::firstOrCreate([
                    'gps' => $p['gpsPos']
                ], [
                    'name' => $p['name'],
                    'place_type' => $placeType->id
                ]);

                // Asociar con el trek en la tabla pivote
                $trek->interestingPlaces()->syncWithoutDetaching([
                    $interestingPlace->id => ['order' => $p['order'] ?? null]
                ]);
            }
        }
    }
}

