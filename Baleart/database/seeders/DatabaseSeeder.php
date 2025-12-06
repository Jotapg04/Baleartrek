<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Image;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeders 
        $this->call([
            RolesSeeder::class,
            PlacesTypeSeeder::class,       
            UsersSeeder::class,      
            IslandsSeeder::class,     
            ZonesSeeder::class,       
            MunicipalitiesSeeder::class,
            TreksSeeder::class,
            PlacesSeeder::class,      
            MeetingsSeeder::class,    
            MeetingUserSeeder::class,
            InterestingPlaceSeeder::class

        ]);

        // Factories 
        User::factory(10)->create(['role_id' => Role::where('name', 'visitant')->first()->id,]);   
        Image::factory()->count(20)->create();  
    }
}
