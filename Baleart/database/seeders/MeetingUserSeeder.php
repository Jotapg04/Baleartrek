<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meeting;
use App\Models\User;

class MeetingUserSeeder extends Seeder
{
    public function run(): void
    {
        $meetings = Meeting::all();
        $users = User::all();

        foreach ($meetings as $meeting) {
            // Generamos un número aleatorio entre 5 y 30 para cada meeting
            // Así algunos tendrán el guía acompañante (>=20) y otros no (<20)
            $cantidad = rand(5, 30);
            
            // Tomamos usuarios aleatorios y los vinculamos
            $asistentes = $users->random($cantidad)->pluck('id');
            
            $meeting->users()->attach($asistentes);
        }
    }
}