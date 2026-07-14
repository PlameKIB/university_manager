<?php

namespace App\Livewire\Cotation;

use App\Models\CourseAssignment;
use App\Models\Grade as GradeModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Grade extends Component
{
    public CourseAssignment $courseAssignment;

    public $grades = []; // [student_user_id => ['tp' => .., 'interro' => .., 'examen' => ..]]

    public function mount(CourseAssignment $courseAssignment)
    {
        // Sécurité : un enseignant ne peut coter que ses propres cours
        abort_unless(
            $courseAssignment->user_id === auth()->id() || auth()->user()->hasRole('admin'),
            403
        );

        $this->courseAssignment = $courseAssignment;

        $students = $courseAssignment->promotion
            ->enrollments()
            ->where('academic_year_id', $courseAssignment->academic_year_id)
            ->where('status', 'active')
            ->with('user')
            ->get();

        $existingGrades = GradeModel::where('course_assignment_id', $courseAssignment->id)
            ->get()
            ->keyBy('user_id');

        foreach ($students as $enrollment) {
            $studentId = $enrollment->user_id;
            $existing = $existingGrades->get($studentId);

            $this->grades[$studentId] = [
                'tp' => $existing?->tp,
                'interro' => $existing?->interro,
                'examen' => $existing?->examen,
            ];
        }
    }

    public function save()
    {
        $bareme = [
            'tp' => $this->courseAssignment->bareme_tp,
            'interro' => $this->courseAssignment->bareme_interro,
            'examen' => $this->courseAssignment->bareme_examen,
        ];

        $rules = [];
        foreach ($this->grades as $studentId => $note) {
            $rules["grades.$studentId.tp"] = "nullable|numeric|min:0|max:{$bareme['tp']}";
            $rules["grades.$studentId.interro"] = "nullable|numeric|min:0|max:{$bareme['interro']}";
            $rules["grades.$studentId.examen"] = "nullable|numeric|min:0|max:{$bareme['examen']}";
        }

        $this->validate($rules, [], [
            'tp' => 'TP',
            'interro' => 'Interro',
            'examen' => 'Examen',
        ]);

        DB::transaction(function () {
            foreach ($this->grades as $studentId => $note) {
                GradeModel::updateOrCreate(
                    [
                        'course_assignment_id' => $this->courseAssignment->id,
                        'user_id' => $studentId,
                    ],
                    [
                        'tp' => $note['tp'],
                        'interro' => $note['interro'],
                        'examen' => $note['examen'],
                    ]
                );
            }
        });

        $this->dispatch('success', message: 'Notes enregistrées avec succès');
    }

    public function render()
    {
        $students = $this->courseAssignment->promotion
            ->enrollments()
            ->where('academic_year_id', $this->courseAssignment->academic_year_id)
            ->where('status', 'active')
            ->with('user')
            ->get();

        return view('livewire.cotation.grade', [
            'students' => $students,
        ]);
    }
}