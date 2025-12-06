<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trek;
use App\Models\Meeting;
use App\Models\Comment;
use App\Models\User;


class MeetingsSeeder extends Seeder
{
    public function run(): void
    {
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\treks.json');
        $data = json_decode($jsonData, true);

        foreach ($data as $t) {
            $trek = Trek::where('reg_number', $t['regNumber'])->first();

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
