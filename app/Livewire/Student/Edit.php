<?php

namespace App\Livewire\Student;

use App\Models\Student;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Edit extends Component
{
    public User $user;

    // =========================
    // FORM FIELDS
    // =========================
    #[Rule('required|string|min:3', as: 'Nom complet')]
    public $name;
    #[Rule('required|string|max:50', as: 'Genre')]
    public $genre;
    #[Rule('required|string|max:50', as: 'telephone')]
    public $telephone;
    #[Rule('required|email|max:50', as: 'G-mail')]
    public $email;
    #[Rule('required|string|max:50', as: 'Adresse')]
    public $adresse;
    #[Rule('required|date', as: 'Date de naissance')]
    public $date_naissance;

    // =========================
    // MOUNT
    // =========================
    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;

        $this->telephone = $user->telephone;
        $this->email = $user->email;
        $this->adresse = $user->adresse;
        $this->genre = $user->genre;
        $this->date_naissance = $user->date_naissance;
    }
    // =========================
    // UPDATE
    // =========================
    public function update()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'genre' => $this->genre,
            'date_naissance' => $this->date_naissance,

        ]);

        session()->flash(
            'success',
            'Informations de l’étudiant mises à jour avec succès.'
        );

        return redirect()->route('student.index');
    }

    public function render()
    {
        return view('livewire.student.edit');
    }
}