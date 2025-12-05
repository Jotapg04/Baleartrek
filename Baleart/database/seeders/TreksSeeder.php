<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trek;
use App\Models\Meeting;
use App\Models\Comment;
use App\Models\User;
use App\Models\Municipality;


class TreksSeeder extends Seeder
{
    public function run(): void
    {
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\treks.json');
        $data = json_decode($jsonData, true);

        $adminUser = User::where('name', 'admin')->first();

        foreach ($data as $t) {
            //Si no existe usa admin
            $guide = isset($t['guide']) ? User::where('id', $t['guide'])->first() : $adminUser;

            $trek = Trek::create([
                'reg_number' => $t['regNumber'],
                'name' => $t['name'],
                'municipality_id' => Municipality::where('name', $t['municipality'])->first()->id,
                'user_id' => $guide->id,
            ]);

            foreach ($t['meetings'] as $m) {
                $meeting = Meeting::create([
                    'trek_id' => $trek->id,
                    'day' => $m['day'],
                    'time' => $m['time'],
                    'guide_responsible_id' => User::where('dni', $m['DNI'])->first()->id,
                ]);

                foreach ($m['comments'] as $c) {
                    Comment::create([
                        'meeting_id' => $meeting->id,
                        'user_id' => User::where('dni', $c['DNI'])->first()->id,
                        'comment' => $c['comment'],
                        'score' => $c['score'],
                    ]);
                }
            }
        }
    }
}
