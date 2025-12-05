<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meeting;
use App\Models\User;

class MeetingUserSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos todos los meetings
        $meetings = Meeting::all();

        // Obtenemos todos los usuarios de tipo 'visitant'
        $visitants = User::where('role', 'visitant')->get();

        foreach ($meetings as $meeting) {
            // Elegimos 20 usuarios aleatorios (o todos si hay menos de 20)
            $selectedVisitants = $visitants->random(min(20, $visitants->count()));

            // Insertamos la relación meeting_user
            foreach ($selectedVisitants as $user) {
                // Evitamos duplicados
                if (!$meeting->users->contains($user->id)) {
                    $meeting->users()->attach($user->id);
                }
            }
        }
    }
}
