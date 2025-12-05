<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trek;
use App\Models\Meeting;
use App\Models\Comment;

class MeetingsSeeder extends Seeder
{
    public function run(): void
    {
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\treks.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $t) {
            $trek = Trek::where('regNumber', $t['regNumber'])->first();

            foreach ($t['meetings'] as $m) {
                $meeting = Meeting::create([
                    'trek_id' => $trek->id,
                    'day' => $m['day'],
                    'time' => $m['time'],
                    'DNI' => $m['DNI'],
                ]);

                foreach ($m['comments'] as $c) {
                    Comment::create([
                        'meeting_id' => $meeting->id,
                        'DNI' => $c['DNI'],
                        'comment' => $c['comment'],
                        'score' => $c['score'],
                    ]);
                }
            }
        }
    }
}
