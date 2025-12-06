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
            // Elegimos 20 usuarios aleatorios (o todos si hay menos de 20)
            $selectedUsers = $users->random(min(20, $users->count()));

            // Asociamos los usuarios al meeting sin duplicar
            foreach ($selectedUsers as $user) {
                $meeting->users()->attach($user->id);
            }
        }
    }
}
