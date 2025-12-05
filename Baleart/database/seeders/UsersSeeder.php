<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    public function run(): void
    {

        $user = new User();
        $user->name = 'Admin';
        $user->lastName = 'Admin';
        $user->dni = '00000000A';
        $user->email = 'admin@baleartrek.com';
        $user->email_verified_at = now();
        $user->phone = '000000000';
        $user->password = Hash::make('12345678');
        $user->role =  Role::where('name', 'admin')->first()->id;
        $user->save();


        //Guias desde un JSON
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\users.json');
        $data = json_decode($jsonData, true);

        foreach ($data['usuaris']['usuari'] as $u) {
            $user = new User();
            $user->name = $u['nom'];
            $user->lastName = $u['llinatges'];
            $user->email = $u['email'];
            $user->password = Hash::make($u['password']);
            $user->dni = $u['dni'];
            $user->phone = $u['telefon'];
            $user->role = Role::where('name', 'guia')->first()->id;
            $user->save();
        }
    }
}
