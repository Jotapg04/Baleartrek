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
            
            $selectedUsers = $users->random(min(20, $users->count()));

            foreach ($selectedUsers as $user) {
                $meeting->users()->attach($user->id);
            }
        }
    }
}
