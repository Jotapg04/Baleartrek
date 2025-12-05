<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipality;

class MunicipalitiesSeeder extends Seeder
{
    public function run(): void
    {
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\municipalities.json');
        $data = json_decode($jsonData, true);

        foreach($data['municipis']['municipi'] as $m){

            $municipality = new Municipality();
            $municipality -> name = $m['Nom'];
            $municipality -> island = $m['Illa'];
            $municipality -> zone = $m['Zona'];
            $municipality -> save();
        }
    }
}
