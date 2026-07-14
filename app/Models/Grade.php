<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'course_assignment_id',
        'student_id',
        'tp',
        'interro',
        'examen',
    ];
    public function courseAssignment()
    {
        return $this->belongsTo(CourseAssignment::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function getAverageAttribute()
    {
        $tp = $this->tp ?? 0;
        $interro = $this->interro ?? 0;
        $examen = $this->examen ?? 0;

        return ($tp + $interro + $examen) / 3;
    }
}
