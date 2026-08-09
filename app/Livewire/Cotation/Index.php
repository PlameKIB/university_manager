<?php

namespace App\Livewire\Cotation;

use App\Models\AcademicYear;
use App\Models\CourseAssignment;
use App\Models\Enrollment;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $activeYear = AcademicYear::where('is_active', true)->first();

        $assignments = CourseAssignment::with(['course', 'promotion'])
            ->when(!auth()->user()->hasRole('admin'), fn($q) => $q->where('user_id', auth()->id()))
            ->when($activeYear, fn($q) => $q->where('academic_year_id', $activeYear->id))
            ->get()
            ->map(function ($assignment) {
                $assignment->students_count = Enrollment::where('promotion_id', $assignment->promotion_id)
                    ->where('academic_year_id', $assignment->academic_year_id)
                    ->where('status', 'active')
                    ->count();

                $assignment->graded_count = $assignment->grades()->count();

                return $assignment;
            });

        return view('livewire.cotation.index', [
            'assignments' => $assignments,
            'activeYear' => $activeYear,
        ]);
    }
}