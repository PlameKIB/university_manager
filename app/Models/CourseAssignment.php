<?php

namespace App\Models;
use App\Models;
use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CourseAssignment extends Model
{
    protected $fillable = [
        'course_id',
        'promotion_id',
        'user_id',       // anciennement user_id
        'academic_year_id',
        'credit',
        'bareme_tp',
        'bareme_interro',
        'bareme_examen',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function getBaremeTotalAttribute(): float
    {
        return (float) $this->bareme_tp + (float) $this->bareme_interro + (float) $this->bareme_examen;
    }
}