<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeders independientes primero
        $this->call([
            RolesSeeder::class,       // Roles: admin, guia, visitante
            UsersSeeder::class,       // Usuarios: admin, guías
            IslandsSeeder::class,     // Islas
            ZonesSeeder::class,        // Zonas
            MunicipalitiesSeeder::class,
            //InterestingPlaceSeeder::class

        ]);

        // Seeders que dependen de los anteriores
        $this->call([
            TreksSeeder::class,       // Treks dependen de Zones e Islands
            PlacesSeeder::class,      // Places dependen de Treks
            MeetingsSeeder::class,    // Meetings dependen de Treks y Usuarios (guías)
            MeetingUserSeeder::class  // Usuarios visitantes dependen de Meetings y Users
        ]);

        // Factories para generar datos adicionales
        \App\Models\User::factory(10)->create();    // Usuarios de tipo visitante
        \App\Models\Image::factory(20)->create();  // Imágenes
    }
}
