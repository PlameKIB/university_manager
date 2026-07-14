<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['department_id', 'name'];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
     public function courseAssignments()
    {
        return $this->hasMany(CourseAssignment::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
