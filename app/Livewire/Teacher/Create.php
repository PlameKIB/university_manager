<?php

namespace App\Livewire\Teacher;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{


    #[Rule('required|string|min:3', as: 'Nom complet')]
    public $name;
    #[Rule('nullable|string', as: 'Téléphone')]
    public $telephone;

    #[Rule('required|email', as: 'Email')]
    public $email;

    public $password;
    public $user_id;

    public $isEditing = false;


    protected function rulesForUpdate(): array
    {
        return [
            'name' => 'required|string|min:3, as: "Nom complet"',
            'telephone' => 'nullable|string|min:8|max:15, as: "Téléphone"',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
        ];
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {

            $user = User::create([
                'matricule' => $this->genereMatricule(),
                'name' => $this->name,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('enseignant');
        });

        $this->reset();

        $this->dispatch('success', message: 'Enseignant ajouté avec succès');
    }

    public function edit($id)
    {
        $teacher = User::findOrFail($id);

        $this->user_id = $teacher->id;

        $this->name = $teacher->name;
        $this->telephone = $teacher->telephone;
        $this->email = $teacher->email;

        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        DB::transaction(function () {
            $user = User::findOrFail($this->user_id);

            $user->update([
                'name' => $this->name,
                'telephone' => $this->telephone,
                'email' => $this->email,
            ]);

        });

        $this->reset();

        $this->isEditing = false;

        $this->dispatch('success', message: 'Enseignant modifié avec succès');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        DB::transaction(function () use ($user) {
            $user->delete();
            $user?->delete();
        });

        $this->dispatch('success', message: 'Enseignant supprimé');
    }
    public function genereMatricule()
    {
        $lastTeacher = User::role('enseignant')->latest('id')->first();
        $lastId = $lastTeacher ? $lastTeacher->id : 0;
        $newId = $lastId + 1;
        return 'ENS' . str_pad($newId, 4, '0', STR_PAD_LEFT);
    }
    public function render()
    {
        return view('livewire.teacher.create', [
            'teachers' => User::role('enseignant')->paginate(10),
        ]);
    }
}
