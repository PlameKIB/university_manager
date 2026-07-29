<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            ['name' => '2020-2021', 'is_active' => false],
            ['name' => '2021-2022', 'is_active' => false],
            ['name' => '2022-2023', 'is_active' => false],
            ['name' => '2023-2024', 'is_active' => false],
            ['name' => '2024-2025', 'is_active' => false],
            ['name' => '2025-2026', 'is_active' => true],
        ];

        foreach ($years as $year) {
            AcademicYear::firstOrCreate(
                ['name' => $year['name']],
                ['is_active' => $year['is_active']]
            );
        }
    }
}
