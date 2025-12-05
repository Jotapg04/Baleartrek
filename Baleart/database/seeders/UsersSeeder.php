<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@baleartrek.com';
        $user->password = Hash::make('12345678');
        $user->role = 'admin';
        $user->save();


        //Guias desde un JSON
        $jsonData = file_get_contents('c:\\temp\\baleartrek\\users.json');
        $data = json_decode($jsonData, true);

        foreach ($data['usuaris']['usuari'] as $u) {
            $user = new User();
            $user->name = $u['nom'] . ' ' . $u['llinatges'];
            $user->email = $u['email'];
            $user->password = Hash::make($u['password']);
            $user->dni = $u['dni'];        
            $user->telefon = $u['telefon'];     
            $user->role = 'guia';           
            $user->save();
        }
    }
}
