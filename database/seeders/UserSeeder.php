<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Abraham Alanya',
            'email' => 'abraham.alanya@indotechsac.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('sistema');
    }
}
