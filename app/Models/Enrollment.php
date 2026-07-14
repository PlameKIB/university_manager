<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'academic_year_id',
        'faculty_id',
        'department_id',
        'promotion_id',
        'registration_date',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
