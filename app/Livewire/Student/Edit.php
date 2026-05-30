<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Livewire\Component;

class Edit extends Component
{
    public Student $student;

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
    // MOUNT
    // =========================
    public function mount(Student $student)
    {
        $this->student = $student;

        $this->matricule      = $student->matricule;
        $this->nom            = $student->nom;
        $this->postnom        = $student->postnom;
        $this->prenom         = $student->prenom;
        $this->telephone      = $student->telephone;
        $this->email          = $student->email;
        $this->adresse        = $student->adresse;
        $this->genre          = $student->genre;
        $this->date_naissance = $student->date_naissance;
    }

    // =========================
    // RULES
    // =========================
    protected function rules()
    {
        return [

            'matricule' => [
                'required',
                'string',
                'max:50',
                'unique:students,matricule,' . $this->student->id,
            ],

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
    // UPDATE
    // =========================
    public function update()
    {
        $this->validate();

        $this->student->update([

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
            'Informations de l’étudiant mises à jour avec succès.'
        );

        return redirect()->route('student.index');
    }

    // =========================
    // RENDER
    // =========================
    public function render()
    {
        return view('livewire.student.edit');
    }
}