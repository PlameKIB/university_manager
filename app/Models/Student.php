<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['matricule', 'nom', 'postnom', 'prenom', 'genre', 'date_naissance', 'telephone', 'email', 'adresse', 'photo'];
    // public function 
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
