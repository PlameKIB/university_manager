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
        Role::firstOrCreate(['name' => 'apparitaire']);
        Role::firstOrCreate(['name' => 'caissier']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'My admin',
                'password' => bcrypt('admin@example.com'),
            ]
        );

        $admin->assignRole('admin');

        
 // Apparitaire : gère les inscriptions, les étudiants et les documents académiques
        $apparitaire = User::firstOrCreate(
            ['email' => 'apparitaire@example.com'],
            [
                'name' => 'Apparitaire',
                'password' => bcrypt('apparitaire@example.com'),
            ]
        );
        $apparitaire->assignRole('apparitaire');
        // Caissier : gère les paiements et les soldes des étudiants
        $caissier = User::firstOrCreate(
            ['email' => 'caissier@example.com'],
            [
                'name' => 'Caissier',
                'password' => bcrypt('caissier@example.com'),
            ]
        );
        $caissier->assignRole('caissier');

        $this->call([
            AcademicYearSeeder::class,
            FacultyDepartmentPromotionSeeder::class,
            CongoleseStudentEnrollmentSeeder::class,
            TeacherCourseSeeder::class,
            GradePaymentSeeder::class,
        ]);
    }
}
