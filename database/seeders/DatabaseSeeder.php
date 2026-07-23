<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'enseignant']);
        Role::firstOrCreate(['name' => 'student']);


        $admin = User::factory()->create([
            'name' => 'My admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin@example.com'),
        ]);

        $admin->assignRole('admin');
    }
}
