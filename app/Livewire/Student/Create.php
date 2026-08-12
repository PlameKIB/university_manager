<?php

namespace App\Livewire\Student;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;


class Create extends Component
{
  

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

    public function save()
    {
        $this->validate();

        $user = User::create([

            'matricule' => $this->genereMatricule(),
            'name' => $this->name,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'genre' => $this->genre,
            'date_naissance' => $this->date_naissance,
            'password'=> Hash::make($this->email)

        ]);
        $user->assignRole('student');

        return redirect()->route('student.index');
    }

    public function genereMatricule()
    {
        $lastStudent = User::role('student')->latest('id')->first();
        $lastId = $lastStudent ? $lastStudent->id : 0;
        $newId = $lastId + 1;
        return 'ETU' . str_pad($newId, 4, '0', STR_PAD_LEFT);
    }
    public function render()
    {
        return view('livewire.student.create');
    }
}