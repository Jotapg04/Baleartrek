<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;

class ZonesSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            'Centre',
            'Ponent',
            'Nord',
            'Llevant',
            'Sud',
        ];

        foreach ($zones as $zone) {
            $newZone = new Zone();
            $newZone->name = $zone;
            $newZone->save();
        }

        $jsonData = file_get_contents('c:\\temp\\baleartrek\\zones.json');
        $data = json_decode($jsonData, true);

        foreach($data['zones']['zona'] as $z){

            $zone = new Zone();
            $zone -> name = $z['Nom'];
            $zone -> save();
        }
    }
}
