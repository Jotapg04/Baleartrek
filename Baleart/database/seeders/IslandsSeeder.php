<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Island;

class IslandsSeeder extends Seeder
{
    public function run(): void
    {
        $islands = [
            'Mallorca',
            'Menorca',
            'Eivissa',
            'Formentera',
            'Cabrera',
        ];

        foreach ($islands as $island) {
            $newIsland = new Island();
            $newIsland->name = $island;
            $newIsland->save();
        }

        //Con un JSON

        $jsonData = file_get_contents('c:\\temp\\baleartrek\\islands.json');
        $data = json_decode($jsonData, true);

        foreach($data['illes']['illa'] as $i){

            $island = new Island();
            $island -> name = $i['Nom'];
            $island -> save();
        }
    }
}
