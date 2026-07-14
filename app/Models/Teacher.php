<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'matricule',
        'nom',
        'postnom',
        'prenom',
        'telephone',
        'email',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
