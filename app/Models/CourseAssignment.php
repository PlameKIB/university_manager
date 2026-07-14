<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAssignment extends Model
{
    protected $fillable = [
        'teacher_id',
        'course_id',
        'grade_id',
    ];
}
