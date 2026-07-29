<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\Department;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherCourseSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'matricule' => 'TEACH-001',
                'name' => 'Jean-Bosco Bemba',
                'email' => 'jeanbosco.bemba@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243812345678',
                'date_naissance' => '1980-02-12',
                'adresse' => 'Kinshasa, Gombe',
            ],
            [
                'matricule' => 'TEACH-002',
                'name' => 'Marie-Claire Ngoma',
                'email' => 'marieclaire.ngoma@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243813456789',
                'date_naissance' => '1982-10-20',
                'adresse' => 'Lubumbashi, Kampemba',
            ],
            [
                'matricule' => 'TEACH-003',
                'name' => 'Thierry Kalonji',
                'email' => 'thierry.kalonji@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243814567890',
                'date_naissance' => '1978-05-05',
                'adresse' => 'Goma, Katindo',
            ],
            [
                'matricule' => 'TEACH-004',
                'name' => 'Adeline Lumumba',
                'email' => 'adeline.lumumba@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243815678901',
                'date_naissance' => '1985-11-10',
                'adresse' => 'Kisangani, Mangobo',
            ],
            [
                'matricule' => 'TEACH-005',
                'name' => 'Emmanuel Kasongo',
                'email' => 'emmanuel.kasongo@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243816789012',
                'date_naissance' => '1976-03-28',
                'adresse' => 'Bukavu, Bagira',
            ],
        ];

        $teachersByEmail = [];
        foreach ($teachers as $teacherData) {
            $teacher = User::firstOrCreate(
                ['email' => $teacherData['email']],
                array_merge($teacherData, [
                    'password' => bcrypt('prof2026'),
                ])
            );

            $teacher->assignRole('enseignant');
            $teachersByEmail[$teacher->email] = $teacher;
        }

        $courses = [
            ['code' => 'INF101', 'intitule' => 'Informatique générale'],
            ['code' => 'INF201', 'intitule' => 'Programmation et algorithmique'],
            ['code' => 'INF301', 'intitule' => 'Informatique avancée'],
            ['code' => 'MAT101', 'intitule' => 'Analyse mathématique'],
            ['code' => 'MAT201', 'intitule' => 'Mathématiques pour l’ingénierie'],
            ['code' => 'BIO101', 'intitule' => 'Biologie cellulaire'],
            ['code' => 'BIO201', 'intitule' => 'Génétique et biologie moléculaire'],
            ['code' => 'ECO101', 'intitule' => 'Microéconomie'],
            ['code' => 'ECO201', 'intitule' => 'Macroéconomie'],
            ['code' => 'ECO301', 'intitule' => 'Macroéconomie avancée'],
            ['code' => 'DRO101', 'intitule' => 'Droit constitutionnel'],
            ['code' => 'DRO201', 'intitule' => 'Droit administratif'],
            ['code' => 'COM101', 'intitule' => 'Communication professionnelle'],
            ['code' => 'COM201', 'intitule' => 'Techniques de communication'],
            ['code' => 'MED101', 'intitule' => 'Introduction à la médecine'],
            ['code' => 'MED201', 'intitule' => 'Santé publique avancée'],
            ['code' => 'PHI101', 'intitule' => 'Physique générale'],
            ['code' => 'PHI201', 'intitule' => 'Physique appliquée'],
            ['code' => 'GES101', 'intitule' => 'Fondements de la gestion'],
            ['code' => 'GES201', 'intitule' => 'Gestion stratégique'],
            ['code' => 'POL101', 'intitule' => 'Introduction aux sciences politiques'],
            ['code' => 'SOC201', 'intitule' => 'Sociologie des organisations'],
            ['code' => 'PHA101', 'intitule' => 'Pharmacie générale'],
            ['code' => 'PHA201', 'intitule' => 'Pharmacologie clinique'],
        ];

        $coursesByCode = [];
        foreach ($courses as $courseData) {
            $course = Course::firstOrCreate(
                ['code' => $courseData['code']],
                ['intitule' => $courseData['intitule']]
            );
            $coursesByCode[$course->code] = $course;
        }

        $assignments = [
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Informatique',
                'promotion' => 'L1',
                'course_code' => 'INF101',
                'teacher_email' => 'jeanbosco.bemba@unikin.cd',
                'year' => '2020-2021',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Informatique',
                'promotion' => 'L2',
                'course_code' => 'INF201',
                'teacher_email' => 'marieclaire.ngoma@unikin.cd',
                'year' => '2021-2022',
                'credit' => 5,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Biologie',
                'promotion' => 'L1',
                'course_code' => 'BIO101',
                'teacher_email' => 'thierry.kalonji@unikin.cd',
                'year' => '2021-2022',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences Économiques et Gestion',
                'department' => 'Économie',
                'promotion' => 'L2',
                'course_code' => 'ECO201',
                'teacher_email' => 'adeline.lumumba@unikin.cd',
                'year' => '2021-2022',
                'credit' => 3,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences Économiques et Gestion',
                'department' => 'Économie',
                'promotion' => 'M1',
                'course_code' => 'ECO301',
                'teacher_email' => 'adeline.lumumba@unikin.cd',
                'year' => '2023-2024',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Droit',
                'department' => 'Droit public',
                'promotion' => 'L3',
                'course_code' => 'DRO101',
                'teacher_email' => 'emmanuel.kasongo@unikin.cd',
                'year' => '2020-2021',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Droit',
                'department' => 'Droit public',
                'promotion' => 'M1',
                'course_code' => 'DRO201',
                'teacher_email' => 'emmanuel.kasongo@unikin.cd',
                'year' => '2021-2022',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Lettres et Sciences Humaines',
                'department' => 'Communication',
                'promotion' => 'L2',
                'course_code' => 'COM201',
                'teacher_email' => 'marieclaire.ngoma@unikin.cd',
                'year' => '2023-2024',
                'credit' => 3,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Médecine',
                'department' => 'Santé publique',
                'promotion' => 'M2',
                'course_code' => 'MED201',
                'teacher_email' => 'thierry.kalonji@unikin.cd',
                'year' => '2024-2025',
                'credit' => 5,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Mathématiques Appliquées',
                'promotion' => 'L3',
                'course_code' => 'MAT201',
                'teacher_email' => 'jeanbosco.bemba@unikin.cd',
                'year' => '2022-2023',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Physique',
                'promotion' => 'L2',
                'course_code' => 'PHI101',
                'teacher_email' => 'emmanuel.kasongo@unikin.cd',
                'year' => '2023-2024',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences Économiques et Gestion',
                'department' => 'Gestion',
                'promotion' => 'D1',
                'course_code' => 'GES201',
                'teacher_email' => 'adeline.lumumba@unikin.cd',
                'year' => '2025-2026',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Droit',
                'department' => 'Sciences politiques',
                'promotion' => 'L2',
                'course_code' => 'POL101',
                'teacher_email' => 'adeline.lumumba@unikin.cd',
                'year' => '2021-2022',
                'credit' => 3,
                'bareme_tp' => 10,
                'bareme_interro' => 25,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Lettres et Sciences Humaines',
                'department' => 'Sociologie',
                'promotion' => 'L3',
                'course_code' => 'SOC201',
                'teacher_email' => 'marieclaire.ngoma@unikin.cd',
                'year' => '2022-2023',
                'credit' => 3,
                'bareme_tp' => 10,
                'bareme_interro' => 25,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Médecine',
                'department' => 'Pharmacie',
                'promotion' => 'M1',
                'course_code' => 'PHA101',
                'teacher_email' => 'thierry.kalonji@unikin.cd',
                'year' => '2021-2022',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Informatique',
                'promotion' => 'L3',
                'course_code' => 'INF301',
                'teacher_email' => 'jeanbosco.bemba@unikin.cd',
                'year' => '2022-2023',
                'credit' => 5,
                'bareme_tp' => 10,
                'bareme_interro' => 30,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Physique',
                'promotion' => 'L3',
                'course_code' => 'PHI201',
                'teacher_email' => 'emmanuel.kasongo@unikin.cd',
                'year' => '2024-2025',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Mathématiques Appliquées',
                'promotion' => 'L1',
                'course_code' => 'MAT101',
                'teacher_email' => 'jeanbosco.bemba@unikin.cd',
                'year' => '2021-2022',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Biologie',
                'promotion' => 'L2',
                'course_code' => 'BIO201',
                'teacher_email' => 'thierry.kalonji@unikin.cd',
                'year' => '2022-2023',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Lettres et Sciences Humaines',
                'department' => 'Communication',
                'promotion' => 'L1',
                'course_code' => 'COM101',
                'teacher_email' => 'marieclaire.ngoma@unikin.cd',
                'year' => '2022-2023',
                'credit' => 3,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences Économiques et Gestion',
                'department' => 'Gestion',
                'promotion' => 'L1',
                'course_code' => 'GES101',
                'teacher_email' => 'adeline.lumumba@unikin.cd',
                'year' => '2020-2021',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Droit',
                'department' => 'Sciences politiques',
                'promotion' => 'L1',
                'course_code' => 'POL101',
                'teacher_email' => 'adeline.lumumba@unikin.cd',
                'year' => '2020-2021',
                'credit' => 3,
                'bareme_tp' => 10,
                'bareme_interro' => 25,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté des Sciences',
                'department' => 'Informatique',
                'promotion' => 'M1',
                'course_code' => 'MED101',
                'teacher_email' => 'thierry.kalonji@unikin.cd',
                'year' => '2024-2025',
                'credit' => 5,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Médecine',
                'department' => 'Pharmacie',
                'promotion' => 'L2',
                'course_code' => 'PHA101',
                'teacher_email' => 'thierry.kalonji@unikin.cd',
                'year' => '2021-2022',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Droit',
                'department' => 'Sciences politiques',
                'promotion' => 'D2',
                'course_code' => 'POL101',
                'teacher_email' => 'adeline.lumumba@unikin.cd',
                'year' => '2025-2026',
                'credit' => 3,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Droit',
                'department' => 'Droit public',
                'promotion' => 'D3',
                'course_code' => 'DRO201',
                'teacher_email' => 'emmanuel.kasongo@unikin.cd',
                'year' => '2025-2026',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
            [
                'faculty' => 'Faculté de Médecine',
                'department' => 'Pharmacie',
                'promotion' => 'M2',
                'course_code' => 'PHA201',
                'teacher_email' => 'thierry.kalonji@unikin.cd',
                'year' => '2025-2026',
                'credit' => 4,
                'bareme_tp' => 10,
                'bareme_interro' => 20,
                'bareme_examen' => 50,
            ],
        ];

        foreach ($assignments as $assignmentData) {
            $department = Department::where('name', $assignmentData['department'])
                ->whereHas('faculty', fn ($query) => $query->where('name', $assignmentData['faculty']))
                ->first();

            if (! $department) {
                continue;
            }

            $promotion = Promotion::where('department_id', $department->id)
                ->where('name', $assignmentData['promotion'])
                ->first();

            if (! $promotion) {
                continue;
            }

            $course = $coursesByCode[$assignmentData['course_code']] ?? null;
            $teacher = $teachersByEmail[$assignmentData['teacher_email']] ?? null;
            $academicYear = AcademicYear::where('name', $assignmentData['year'])->first();

            if (! $course || ! $teacher || ! $academicYear) {
                continue;
            }

            CourseAssignment::updateOrCreate(
                [
                    'course_id' => $course->id,
                    'promotion_id' => $promotion->id,
                    'academic_year_id' => $academicYear->id,
                ],
                [
                    'user_id' => $teacher->id,
                    'credit' => $assignmentData['credit'],
                    'bareme_tp' => $assignmentData['bareme_tp'],
                    'bareme_interro' => $assignmentData['bareme_interro'],
                    'bareme_examen' => $assignmentData['bareme_examen'],
                ]
            );
        }
    }
}
