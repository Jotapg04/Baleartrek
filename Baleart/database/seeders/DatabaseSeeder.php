<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Image;
use App\Models\Role;
use App\Models\Comment;

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
            InterestingPlaceSeeder::class

        ]);

        // Factories 
        User::factory(10)->create(['role_id' => Role::where('name', 'visitant')->first()->id,]);
        Image::factory()->count(20)->create();
        User::factory(100)->create();
        Image::factory(100)->create();
        Comment::factory(100)->create();

        $this->call([
            MeetingUserSeeder::class,
        ]);
    }
}
