<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trek;
use App\Models\Meeting;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon; // Importante para las fechas

class MeetingsSeeder extends Seeder
{
    public function run(): void
    {
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\treks.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $t) {
            $trek = Trek::where('reg_number', $t['regNumber'])->first();

            if (!$trek) continue; // Seguridad por si no encuentra el trek

            foreach ($t['meetings'] as $m) {
                // Calculamos las fechas basándonos en el día del meeting
                $eventDay = Carbon::parse($m['day']);
                $dateIni = $eventDay->copy()->subMonth();
                $dateEnd = $eventDay->copy()->subWeek();

                $meeting = Meeting::create([
                    'trek_id' => $trek->id,
                    'day' => $m['day'],
                    'time' => $m['time'],
                    'guide_responsible_id' => User::where('dni', $m['DNI'])->first()->id,
                    'appDateIni' => $dateIni->format('Y-m-d'),
                    'appDateEnd' => $dateEnd->format('Y-m-d'),
                ]);

                foreach ($m['comments'] as $c) {
                    $userComment = User::where('dni', $c['DNI'])->first();
                    
                    if ($userComment) {
                        Comment::create([
                            'meeting_id' => $meeting->id,
                            'user_id' => $userComment->id,
                            'comment' => $c['comment'],
                            'score' => $c['score'],
                        ]);
                    }
                }
            }
        }
    }
}