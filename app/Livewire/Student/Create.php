<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Livewire\Component;

class Create extends Component
{
    // =========================
    // FORM FIELDS
    // =========================
    public $matricule;

    public $nom;

    public $postnom;

    public $prenom;

    public $telephone;

    public $email;

    public $adresse;

    public $genre;

    public $date_naissance;

    // =========================
    // RULES
    // =========================
    protected function rules()
    {
        return [

            'matricule' => 'required|string|max:50|unique:students,matricule',

            'nom' => 'required|string|max:255',

            'postnom' => 'nullable|string|max:255',

            'prenom' => 'nullable|string|max:255',

            'telephone' => 'nullable|string|max:30',

            'email' => 'nullable|email|max:255',

            'adresse' => 'nullable|string|max:255',

            'genre' => 'nullable|in:M,F',

            'date_naissance' => 'nullable|date',
        ];
    }

    // =========================
    // SAVE
    // =========================
    public function save()
    {
        $this->validate();

        Student::create([

            'matricule'      => $this->matricule,
            'nom'            => $this->nom,
            'postnom'        => $this->postnom,
            'prenom'         => $this->prenom,
            'telephone'      => $this->telephone,
            'email'          => $this->email,
            'adresse'        => $this->adresse,
            'genre'          => $this->genre,
            'date_naissance' => $this->date_naissance,

        ]);

        session()->flash(
            'success',
            'Étudiant créé avec succès.'
        );

        return redirect()->route('student.index');
    }

    // =========================
    // RENDER
    // =========================
    public function render()
    {
        return view('livewire.student.create');
    }
}