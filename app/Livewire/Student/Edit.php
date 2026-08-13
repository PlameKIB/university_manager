<?php

namespace App\Livewire\Student;

use App\Models\Student;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

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
    
    // PASSWORD FIELDS
    #[Rule('nullable|string|min:8|confirmed', as: 'Nouveau mot de passe')]
    public $password = '';
    #[Rule('nullable')]
    public $password_confirmation = '';
    
    // PHOTO FIELD
    #[Rule('nullable|image|max:2048', as: 'Photo de profil')]
    public $photo = null;

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
        $this->password = '';
        $this->password_confirmation = '';
        $this->photo = null;
    }
    // =========================
    // UPDATE
    // =========================
    public function update()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'genre' => $this->genre,
            'date_naissance' => $this->date_naissance,
        ];
        
        // Ajouter le mot de passe s'il est fourni
        if (!empty($this->password)) {
            $data['password'] = bcrypt($this->password);
        }

        // Gérer la photo s'il y en a une
        if ($this->photo) {
            // Supprimer l'ancienne photo si elle existe
            if ($this->user->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->user->photo);
            }
            
            // Stocker la nouvelle photo
            $photoPath = $this->photo->store('students', 'public');
            $data['photo'] = $photoPath;
        }

        $this->user->update($data);

        $message = 'Informations de l\'étudiant mises à jour avec succès.';
        if (!empty($this->password)) {
            $message .= ' Le mot de passe a été modifié.';
        }
        if ($this->photo) {
            $message .= ' La photo a été mise à jour.';
        }

        session()->flash(
            'success',
            $message
        );

        return redirect()->route('student.index');
    }

    public function render()
    {
        return view('livewire.student.edit');
    }
}
