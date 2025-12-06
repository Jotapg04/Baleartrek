<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'lastName' => $this->faker->lastName(),
            'dni' => strtoupper($this->faker->bothify('########?#')),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), 
            'phone' => $this->faker->phoneNumber(),
            'role_id' => Role::where('name', 'visitant')->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
