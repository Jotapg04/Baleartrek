<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipality;
use App\Models\Island;
use App\Models\Zone;

class MunicipalitiesSeeder extends Seeder
{
    public function run(): void
    {
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\municipalities.json');
        $data = json_decode($jsonData, true);

        foreach($data['municipis']['municipi'] as $m){

            $municipality = new Municipality();
            $municipality -> name = $m['Nom'];
            $municipality -> island_id = Island::where('name', $m['Illa'])->first()->id;
            $municipality->zone_id = Zone::where('name', $m['Zona'])->first()?->id;
            $municipality -> save();
        }
    }
}
