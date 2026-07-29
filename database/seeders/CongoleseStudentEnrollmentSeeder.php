<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Seeder;

class CongoleseStudentEnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'matricule' => 'CD2020-001',
                'name' => 'Mubiala Mukeba',
                'email' => 'mubiala.mukeba@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243815012345',
                'date_naissance' => '2001-03-22',
                'adresse' => 'Kinshasa, Mont Ngaliema',
                'faculty' => 'Faculté des Sciences',
                'department' => 'Informatique',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L1', 'registration_date' => '2020-09-15', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-14', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-002',
                'name' => 'Awa Bulay',
                'email' => 'awa.bulay@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243994876543',
                'date_naissance' => '2002-07-10',
                'adresse' => 'Goma, avenue de la Paix',
                'faculty' => 'Faculté des Sciences',
                'department' => 'Biologie',
                'enrollments' => [
                    ['year' => '2021-2022', 'promotion' => 'L1', 'registration_date' => '2021-09-18', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L2', 'registration_date' => '2022-09-18', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-003',
                'name' => 'Kalombo Mwana',
                'email' => 'kalombo.mwana@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243824001122',
                'date_naissance' => '2000-01-30',
                'adresse' => 'Lubumbashi, quartier Kenya',
                'faculty' => 'Faculté des Sciences Économiques et Gestion',
                'department' => 'Économie',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L2', 'registration_date' => '2020-09-12', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'L3', 'registration_date' => '2021-09-13', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'M1', 'registration_date' => '2022-09-14', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-004',
                'name' => 'Nangaa Tshibanda',
                'email' => 'nangaa.tshibanda@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243814332211',
                'date_naissance' => '1999-11-05',
                'adresse' => 'Bukavu, avenue de la Liberté',
                'faculty' => 'Faculté de Droit',
                'department' => 'Droit public',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L3', 'registration_date' => '2020-09-20', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'M1', 'registration_date' => '2021-09-20', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-005',
                'name' => 'Kitenge Kabongo',
                'email' => 'kitenge.kabongo@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243819556677',
                'date_naissance' => '2001-12-28',
                'adresse' => 'Kisangani, quartier Mangobo',
                'faculty' => 'Faculté des Lettres et Sciences Humaines',
                'department' => 'Communication',
                'enrollments' => [
                    ['year' => '2022-2023', 'promotion' => 'L1', 'registration_date' => '2022-09-25', 'status' => 'completed'],
                    ['year' => '2023-2024', 'promotion' => 'L2', 'registration_date' => '2023-09-26', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-006',
                'name' => 'Nzanzu Mateta',
                'email' => 'nzanzu.mateta@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243827334455',
                'date_naissance' => '1998-08-17',
                'adresse' => 'Kinshasa, Limete',
                'faculty' => 'Faculté de Médecine',
                'department' => 'Santé publique',
                'enrollments' => [
                    ['year' => '2023-2024', 'promotion' => 'M1', 'registration_date' => '2023-09-10', 'status' => 'completed'],
                    ['year' => '2024-2025', 'promotion' => 'M2', 'registration_date' => '2024-09-10', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-007',
                'name' => 'Mukendi N\'Dombasi',
                'email' => 'mukendi.ndombasi@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243820998877',
                'date_naissance' => '2000-05-04',
                'adresse' => 'Goma, Katindo',
                'faculty' => 'Faculté des Sciences',
                'department' => 'Mathématiques Appliquées',
                'enrollments' => [
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-11', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L3', 'registration_date' => '2022-09-11', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-008',
                'name' => 'Ingele Mosengo',
                'email' => 'ingele.mosengo@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243819334455',
                'date_naissance' => '1997-09-02',
                'adresse' => 'Lubumbashi, avenue Kasavubu',
                'faculty' => 'Faculté des Sciences Économiques et Gestion',
                'department' => 'Gestion',
                'enrollments' => [
                    ['year' => '2024-2025', 'promotion' => 'M2', 'registration_date' => '2024-09-13', 'status' => 'completed'],
                    ['year' => '2025-2026', 'promotion' => 'D1', 'registration_date' => '2025-09-13', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-009',
                'name' => 'Kambale Mulumba',
                'email' => 'kambale.mulumba@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243819223344',
                'date_naissance' => '2001-04-18',
                'adresse' => 'Kisangani, quartier Kabondo',
                'faculty' => 'Faculté de Droit',
                'department' => 'Sciences politiques',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L1', 'registration_date' => '2020-09-22', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-22', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-010',
                'name' => 'Samba Kabila',
                'email' => 'samba.kabila@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243812445566',
                'date_naissance' => '2002-02-14',
                'adresse' => 'Bukavu, quartier Bagira',
                'faculty' => 'Faculté des Lettres et Sciences Humaines',
                'department' => 'Sociologie',
                'enrollments' => [
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-17', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L3', 'registration_date' => '2022-09-17', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-011',
                'name' => 'Mbombo Kashala',
                'email' => 'mbombo.kashala@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243816778899',
                'date_naissance' => '2000-06-29',
                'adresse' => 'Kinshasa, Gombe',
                'faculty' => 'Faculté de Médecine',
                'department' => 'Pharmacie',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L3', 'registration_date' => '2020-09-16', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'M1', 'registration_date' => '2021-09-16', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-012',
                'name' => 'Malela Kasanji',
                'email' => 'malela.kasanji@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243818009900',
                'date_naissance' => '2001-10-11',
                'adresse' => 'Mbuji-Mayi, avenue Tshongo',
                'faculty' => 'Faculté des Sciences',
                'department' => 'Physique',
                'enrollments' => [
                    ['year' => '2022-2023', 'promotion' => 'L1', 'registration_date' => '2022-09-23', 'status' => 'completed'],
                    ['year' => '2023-2024', 'promotion' => 'L2', 'registration_date' => '2023-09-23', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-013',
                'name' => 'Aisha Ntumba',
                'email' => 'aisha.ntumba@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243819007001',
                'date_naissance' => '2002-11-09',
                'adresse' => 'Kinshasa, Bandalungwa',
                'faculty' => 'Faculté des Sciences',
                'department' => 'Biologie',
                'enrollments' => [
                    ['year' => '2021-2022', 'promotion' => 'L1', 'registration_date' => '2021-09-19', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L2', 'registration_date' => '2022-09-19', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-014',
                'name' => 'Rene Mukendi',
                'email' => 'rene.mukendi@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243819008002',
                'date_naissance' => '2001-01-30',
                'adresse' => 'Lubumbashi, Kampemba',
                'faculty' => 'Faculté des Sciences',
                'department' => 'Informatique',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L1', 'registration_date' => '2020-09-10', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-10', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L3', 'registration_date' => '2022-09-10', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-015',
                'name' => 'Julien Mpiana',
                'email' => 'julien.mpiana@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243819009003',
                'date_naissance' => '2000-07-18',
                'adresse' => 'Goma, Karisimbi',
                'faculty' => 'Faculté des Sciences Économiques et Gestion',
                'department' => 'Économie',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L1', 'registration_date' => '2020-09-12', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-12', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L3', 'registration_date' => '2022-09-12', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-016',
                'name' => 'Fabrice Lumbala',
                'email' => 'fabrice.lumbala@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243814009004',
                'date_naissance' => '1999-12-25',
                'adresse' => 'Bukavu, Bagira',
                'faculty' => 'Faculté de Droit',
                'department' => 'Droit public',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L3', 'registration_date' => '2020-09-21', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'M1', 'registration_date' => '2021-09-21', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-017',
                'name' => 'Edith Leya',
                'email' => 'edith.leya@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243816009005',
                'date_naissance' => '2002-03-14',
                'adresse' => 'Kisangani, Mangobo',
                'faculty' => 'Faculté des Lettres et Sciences Humaines',
                'department' => 'Communication',
                'enrollments' => [
                    ['year' => '2022-2023', 'promotion' => 'L1', 'registration_date' => '2022-09-27', 'status' => 'completed'],
                    ['year' => '2023-2024', 'promotion' => 'L2', 'registration_date' => '2023-09-27', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-018',
                'name' => 'Pascal Bakali',
                'email' => 'pascal.bakali@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243817009006',
                'date_naissance' => '2001-08-05',
                'adresse' => 'Lubumbashi, Kenya',
                'faculty' => 'Faculté des Lettres et Sciences Humaines',
                'department' => 'Sociologie',
                'enrollments' => [
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-18', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L3', 'registration_date' => '2022-09-18', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-019',
                'name' => 'Viviane Kitenge',
                'email' => 'viviane.kitenge@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243818009007',
                'date_naissance' => '1998-04-04',
                'adresse' => 'Kinshasa, Bandalungwa',
                'faculty' => 'Faculté de Médecine',
                'department' => 'Pharmacie',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L1', 'registration_date' => '2020-09-17', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-17', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L3', 'registration_date' => '2022-09-17', 'status' => 'completed'],
                    ['year' => '2023-2024', 'promotion' => 'M1', 'registration_date' => '2023-09-17', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-020',
                'name' => 'Serge Mabiala',
                'email' => 'serge.mabiala@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243819009008',
                'date_naissance' => '1997-10-20',
                'adresse' => 'Goma, Katindo',
                'faculty' => 'Faculté des Sciences Économiques et Gestion',
                'department' => 'Gestion',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L1', 'registration_date' => '2020-09-16', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-16', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L3', 'registration_date' => '2022-09-16', 'status' => 'completed'],
                    ['year' => '2023-2024', 'promotion' => 'M1', 'registration_date' => '2023-09-16', 'status' => 'completed'],
                    ['year' => '2024-2025', 'promotion' => 'M2', 'registration_date' => '2024-09-16', 'status' => 'completed'],
                    ['year' => '2025-2026', 'promotion' => 'D1', 'registration_date' => '2025-09-16', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-021',
                'name' => 'Faustin Kambale',
                'email' => 'faustin.kambale@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243824667788',
                'date_naissance' => '1996-03-12',
                'adresse' => 'Lubumbashi, Kampemba',
                'faculty' => 'Faculté de Droit',
                'department' => 'Droit public',
                'enrollments' => [
                    ['year' => '2021-2022', 'promotion' => 'M1', 'registration_date' => '2021-09-24', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'M2', 'registration_date' => '2022-09-24', 'status' => 'completed'],
                    ['year' => '2023-2024', 'promotion' => 'D1', 'registration_date' => '2023-09-24', 'status' => 'completed'],
                    ['year' => '2024-2025', 'promotion' => 'D2', 'registration_date' => '2024-09-24', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-022',
                'name' => 'Nadine Mayala',
                'email' => 'nadine.mayala@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243816667788',
                'date_naissance' => '1995-05-30',
                'adresse' => 'Kinshasa, Bandalungwa',
                'faculty' => 'Faculté de Sciences Économiques et Gestion',
                'department' => 'Économie',
                'enrollments' => [
                    ['year' => '2022-2023', 'promotion' => 'M1', 'registration_date' => '2022-09-18', 'status' => 'completed'],
                    ['year' => '2023-2024', 'promotion' => 'M2', 'registration_date' => '2023-09-18', 'status' => 'completed'],
                    ['year' => '2024-2025', 'promotion' => 'D1', 'registration_date' => '2024-09-18', 'status' => 'completed'],
                    ['year' => '2025-2026', 'promotion' => 'D2', 'registration_date' => '2025-09-18', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-023',
                'name' => 'Mireille Kanza',
                'email' => 'mireille.kanza@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243818667788',
                'date_naissance' => '1994-12-20',
                'adresse' => 'Bukavu, Bagira',
                'faculty' => 'Faculté des Sciences',
                'department' => 'Mathématiques Appliquées',
                'enrollments' => [
                    ['year' => '2020-2021', 'promotion' => 'L1', 'registration_date' => '2020-09-18', 'status' => 'completed'],
                    ['year' => '2021-2022', 'promotion' => 'L2', 'registration_date' => '2021-09-18', 'status' => 'completed'],
                    ['year' => '2022-2023', 'promotion' => 'L3', 'registration_date' => '2022-09-18', 'status' => 'completed'],
                    ['year' => '2023-2024', 'promotion' => 'M1', 'registration_date' => '2023-09-18', 'status' => 'completed'],
                    ['year' => '2024-2025', 'promotion' => 'M2', 'registration_date' => '2024-09-18', 'status' => 'completed'],
                    ['year' => '2025-2026', 'promotion' => 'D2', 'registration_date' => '2025-09-18', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-024',
                'name' => 'Fabrice Tshimanga',
                'email' => 'fabrice.tshimanga@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243828001234',
                'date_naissance' => '1993-06-02',
                'adresse' => 'Kinshasa, Gombe',
                'faculty' => 'Faculté de Droit',
                'department' => 'Sciences politiques',
                'enrollments' => [
                    ['year' => '2024-2025', 'promotion' => 'D1', 'registration_date' => '2024-09-14', 'status' => 'completed'],
                    ['year' => '2025-2026', 'promotion' => 'D2', 'registration_date' => '2025-09-14', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-025',
                'name' => 'Thérèse Nsimba',
                'email' => 'therese.nsimba@unikin.cd',
                'genre' => 'F',
                'telephone' => '+243827112233',
                'date_naissance' => '1995-03-28',
                'adresse' => 'Lubumbashi, Kamalondo',
                'faculty' => 'Faculté de Médecine',
                'department' => 'Pharmacie',
                'enrollments' => [
                    ['year' => '2024-2025', 'promotion' => 'M1', 'registration_date' => '2024-09-15', 'status' => 'completed'],
                    ['year' => '2025-2026', 'promotion' => 'M2', 'registration_date' => '2025-09-15', 'status' => 'active'],
                ],
            ],
            [
                'matricule' => 'CD2020-026',
                'name' => 'Olivier Kabila',
                'email' => 'olivier.kabila@unikin.cd',
                'genre' => 'M',
                'telephone' => '+243829334455',
                'date_naissance' => '1992-11-11',
                'adresse' => 'Kisangani, Mangobo',
                'faculty' => 'Faculté de Droit',
                'department' => 'Droit public',
                'enrollments' => [
                    ['year' => '2024-2025', 'promotion' => 'D2', 'registration_date' => '2024-09-16', 'status' => 'completed'],
                    ['year' => '2025-2026', 'promotion' => 'D3', 'registration_date' => '2025-09-16', 'status' => 'active'],
                ],
            ],
        ];

        foreach ($students as $studentData) {
            $user = User::firstOrCreate(
                ['email' => $studentData['email']],
                [
                    'matricule' => $studentData['matricule'],
                    'name' => $studentData['name'],
                    'genre' => $studentData['genre'],
                    'telephone' => $studentData['telephone'],
                    'date_naissance' => $studentData['date_naissance'],
                    'adresse' => $studentData['adresse'],
                    'password' => bcrypt('congo2026'),
                ]
            );

            $faculty = Faculty::firstOrCreate(['name' => $studentData['faculty']]);
            $department = Department::firstOrCreate([
                'faculty_id' => $faculty->id,
                'name' => $studentData['department'],
            ]);

            foreach ($studentData['enrollments'] as $enrollmentData) {
                $promotion = Promotion::firstOrCreate([
                    'department_id' => $department->id,
                    'name' => $enrollmentData['promotion'],
                ]);

                $academicYear = AcademicYear::firstOrCreate(['name' => $enrollmentData['year']], ['is_active' => false]);

                Enrollment::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'academic_year_id' => $academicYear->id,
                    ],
                    [
                        'faculty_id' => $faculty->id,
                        'department_id' => $department->id,
                        'promotion_id' => $promotion->id,
                        'registration_date' => $enrollmentData['registration_date'],
                        'status' => $enrollmentData['status'],
                    ]
                );
            }

            $user->assignRole('student');
        }
    }
}
