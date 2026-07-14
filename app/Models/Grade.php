<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'course_assignment_id',
        'user_id',        // anciennement user_id
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
        return $this->belongsTo(User::class, 'user_id');
    }

    // Remplace getAverageAttribute() : une moyenne /3 n'a pas de sens ici
    // puisque TP, Interro et Examen ont des barèmes différents (ex: /10, /20, /50).
    public function getCoteFinaleAttribute(): float
    {
        return (float) ($this->tp ?? 0) + (float) ($this->interro ?? 0) + (float) ($this->examen ?? 0);
    }

    public function getPourcentageAttribute(): float
    {
        $bareme = $this->courseAssignment?->bareme_total ?: 1;
        return round(($this->cote_finale / $bareme) * 100, 2);
    }
}
