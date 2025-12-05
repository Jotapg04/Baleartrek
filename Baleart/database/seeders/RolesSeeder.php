<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'guia',
            'visitant',
        ];

        foreach ($roles as $role) {
            $newRole = new Role();
            $newRole->name = $role;
            $newRole->save();
        }
    }
}
