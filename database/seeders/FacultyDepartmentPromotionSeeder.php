<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Promotion;
use Illuminate\Database\Seeder;

class FacultyDepartmentPromotionSeeder extends Seeder
{
    public function run(): void
    {
        $structure = [
            'Faculté des Sciences' => [
                'Informatique' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Mathématiques Appliquées' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Physique' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Biologie' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
            ],
            'Faculté des Sciences Économiques et Gestion' => [
                'Économie' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Gestion' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Sciences Commerciales' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
            ],
            'Faculté de Droit' => [
                'Droit public' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Droit privé' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Sciences politiques' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
            ],
            'Faculté des Lettres et Sciences Humaines' => [
                'Lettres modernes' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Sociologie' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Communication' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
            ],
            'Faculté de Médecine' => [
                'Médecine générale' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Pharmacie' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
                'Santé publique' => ['L1', 'L2', 'L3', 'M1', 'M2', 'D1', 'D2', 'D3'],
            ],
        ];

        foreach ($structure as $facultyName => $departments) {
            $faculty = Faculty::firstOrCreate(['name' => $facultyName]);

            foreach ($departments as $departmentName => $promotions) {
                $department = Department::firstOrCreate([
                    'faculty_id' => $faculty->id,
                    'name' => $departmentName,
                ]);

                foreach ($promotions as $promotionName) {
                    Promotion::firstOrCreate([
                        'department_id' => $department->id,
                        'name' => $promotionName,
                    ]);
                }
            }
        }
    }
}
