<?php

namespace App\Livewire;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\Enrollment;
use App\Models\Fee;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $this->renderAdmin();
        }

        if ($user->hasRole('enseignant')) {
            return $this->renderTeacher($user);
        }

        return $this->renderStudent($user);
    }

    // =========================================================
    // ADMIN : vue globale de l'université
    // =========================================================
    protected function renderAdmin()
    {
        $activeYear = AcademicYear::where('is_active', true)->first();

        $totalStudents = User::role('student')->count();

        $totalTeachers = User::role('enseignant')->count();

        $activeEnrollments = Enrollment::when(
            $activeYear,
            fn($query) => $query->where('academic_year_id', $activeYear->id)
        )
            ->where('status', 'active')
            ->count();

        $totalCourses = Course::count();

        $totalRevenue = (float) Payment::sum('total_amount');

        $monthRevenue = (float) Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('total_amount');

        $monthlyRevenue = collect(range(5, 0))->map(function ($i) {
            $date = now()->subMonths($i);

            $amount = (float) Payment::whereMonth('payment_date', $date->month)
                ->whereYear('payment_date', $date->year)
                ->sum('total_amount');

            return [
                'label' => ucfirst($date->translatedFormat('M')),
                'amount' => $amount,
            ];
        });

        $maxMonthlyRevenue = $monthlyRevenue->max('amount') ?: 1;

        $promotionStats = Promotion::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(6)
            ->get();

        $maxPromotionCount = $promotionStats->max('enrollments_count') ?: 1;

        $recentEnrollments = Enrollment::with(['user', 'promotion'])
            ->latest('registration_date')
            ->take(5)
            ->get();

        $recentPayments = Payment::with('enrollment.user')
            ->latest('payment_date')
            ->take(5)
            ->get();

        return view('livewire.dashboard.admin', [
            'activeYear' => $activeYear,
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'activeEnrollments' => $activeEnrollments,
            'totalCourses' => $totalCourses,
            'totalRevenue' => $totalRevenue,
            'monthRevenue' => $monthRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'maxMonthlyRevenue' => $maxMonthlyRevenue,
            'promotionStats' => $promotionStats,
            'maxPromotionCount' => $maxPromotionCount,
            'recentEnrollments' => $recentEnrollments,
            'recentPayments' => $recentPayments,
        ]);
    }

    // =========================================================
    // ENSEIGNANT : ses cours, ses cotations
    // =========================================================
    protected function renderTeacher(User $user)
    {
        $activeYear = AcademicYear::where('is_active', true)->first();

        $assignments = CourseAssignment::with(['course', 'promotion'])
            ->where('user_id', $user->id)
            ->when($activeYear, fn($q) => $q->where('academic_year_id', $activeYear->id))
            ->get()
            ->map(function ($assignment) {
                $assignment->students_count = $assignment->promotion
                    ->enrollments()
                    ->where('academic_year_id', $assignment->academic_year_id)
                    ->where('status', 'active')
                    ->count();

                $assignment->graded_count = $assignment->grades()->count();

                return $assignment;
            });

        $totalCourses = $assignments->count();

        // Nombre d'étudiants distincts encadrés (toutes promotions confondues)
        $promotionIds = $assignments->pluck('promotion_id')->unique();

        $totalStudents = Enrollment::whereIn('promotion_id', $promotionIds)
            ->when($activeYear, fn($q) => $q->where('academic_year_id', $activeYear->id))
            ->where('status', 'active')
            ->distinct('user_id')
            ->count('user_id');

        $pendingGrading = $assignments->filter(
            fn($assignment) => $assignment->graded_count < $assignment->students_count
        )->count();

        $totalExpectedGrades = $assignments->sum('students_count');
        $totalDoneGrades = $assignments->sum('graded_count');

        $completionRate = $totalExpectedGrades > 0
            ? round(($totalDoneGrades / $totalExpectedGrades) * 100)
            : 0;

        return view('livewire.dashboard.teacher', [
            'activeYear' => $activeYear,
            'assignments' => $assignments,
            'totalCourses' => $totalCourses,
            'totalStudents' => $totalStudents,
            'pendingGrading' => $pendingGrading,
            'completionRate' => $completionRate,
        ]);
    }

    // =========================================================
    // ETUDIANT : ses cours, ses notes, ses paiements
    // =========================================================
    protected function renderStudent(User $user)
    {
        $activeYear = AcademicYear::where('is_active', true)->first();

        $enrollment = Enrollment::with(['promotion', 'department', 'faculty', 'academicYear'])
            ->where('user_id', $user->id)
            ->when($activeYear, fn($q) => $q->where('academic_year_id', $activeYear->id))
            ->latest('registration_date')
            ->first();

        // Si aucune inscription pour l'année active, on prend la plus récente
        if (!$enrollment) {
            $enrollment = Enrollment::with(['promotion', 'department', 'faculty', 'academicYear'])
                ->where('user_id', $user->id)
                ->latest('registration_date')
                ->first();
        }

        if (!$enrollment) {
            return view('livewire.dashboard.student', [
                'enrollment' => null,
            ]);
        }

        $assignments = CourseAssignment::with('course')
            ->where('promotion_id', $enrollment->promotion_id)
            ->where('academic_year_id', $enrollment->academic_year_id)
            ->get();

        $grades = Grade::whereIn('course_assignment_id', $assignments->pluck('id'))
            ->where('user_id', $user->id)
            ->get()
            ->keyBy('course_assignment_id');

        $lines = $assignments->map(function ($assignment) use ($grades) {
            $grade = $grades->get($assignment->id);

            $coteFinale = $grade?->cote_finale ?? 0;
            $baremeTotal = $assignment->bareme_total ?: 1;
            $pourcentage = ($coteFinale / $baremeTotal) * 100;
            $pointsPonderes = ($pourcentage / 100) * $assignment->credit;

            return (object) [
                'course' => $assignment->course,
                'credit' => $assignment->credit,
                'cote_finale' => $coteFinale,
                'bareme_total' => $assignment->bareme_total,
                'pourcentage' => round($pourcentage, 2),
                'points_ponderes' => $pointsPonderes,
                'is_graded' => (bool) $grade,
            ];
        });

        $totalCourses = $lines->count();
        $gradedCourses = $lines->where('is_graded', true)->count();

        $totalCredits = $lines->sum('credit');
        $totalPoints = $lines->sum('points_ponderes');
        $pourcentageGeneral = $totalCredits > 0 ? ($totalPoints / $totalCredits) * 100 : 0;
        $moyenneSur20 = round($pourcentageGeneral * 20 / 100, 2);

        $mention = match (true) {
            $pourcentageGeneral >= 80 => 'La Plus Grande Distinction',
            $pourcentageGeneral >= 70 => 'Grande Distinction',
            $pourcentageGeneral >= 60 => 'Distinction',
            $pourcentageGeneral >= 50 => 'Satisfaction',
            default => 'Échec',
        };

        $decision = $pourcentageGeneral >= 50 ? 'ADMIS(E)' : 'AJOURNÉ(E)';

        // Situation financière
        $totalFees = (float) Fee::where('promotion_id', $enrollment->promotion_id)
            ->where('academic_year_id', $enrollment->academic_year_id)
            ->sum('amount');

        $totalPaid = (float) Payment::where('enrollment_id', $enrollment->id)->sum('total_amount');

        $balance = $totalFees - $totalPaid;

        $recentPayments = Payment::where('enrollment_id', $enrollment->id)
            ->latest('payment_date')
            ->take(5)
            ->get();

        return view('livewire.dashboard.student', [
            'enrollment' => $enrollment,
            'lines' => $lines,
            'totalCourses' => $totalCourses,
            'gradedCourses' => $gradedCourses,
            'pourcentageGeneral' => round($pourcentageGeneral, 2),
            'moyenneSur20' => $moyenneSur20,
            'mention' => $mention,
            'decision' => $decision,
            'totalFees' => $totalFees,
            'totalPaid' => $totalPaid,
            'balance' => $balance,
            'recentPayments' => $recentPayments,
        ]);
    }
}
