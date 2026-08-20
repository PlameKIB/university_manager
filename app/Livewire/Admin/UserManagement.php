<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // =========================
    // FILTERS
    // =========================
    public $search = '';
    public $roleFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
    ];

    // =========================
    // ROLE MODAL
    // =========================
    public $showRoleModal = false;
    public $selectedUserId;
    public $selectedUserName;
    public $selectedUserEmail;
    public array $selectedRoles = [];

    public array $availableRoles = [
        'admin' => 'Administrateur',
        'enseignant' => 'Enseignant',
        'student' => 'Étudiant',
        'apparitaire' => 'Apparitaire',
        'caissier' => 'Caissier',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    // =========================
    // OPEN ROLE MODAL
    // =========================
    public function openRoles($userId)
    {
        $user = User::with('roles')->findOrFail($userId);

        $this->selectedUserId = $user->id;
        $this->selectedUserName = $user->name;
        $this->selectedUserEmail = $user->email;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();

        $this->showRoleModal = true;
    }

    public function closeRoleModal()
    {
        $this->showRoleModal = false;
        $this->reset(['selectedUserId', 'selectedUserName', 'selectedUserEmail', 'selectedRoles']);
    }

    // =========================
    // SAVE ROLES
    // =========================
    public function saveRoles()
    {
        $user = User::findOrFail($this->selectedUserId);

        if (empty($this->selectedRoles)) {
            $this->dispatch('error', message: 'Sélectionnez au moins un rôle pour cet utilisateur.');
            return;
        }

        // On ne peut pas se retirer soi-même le rôle admin
        if (
            $user->id === Auth::id()
            && $user->hasRole('admin')
            && !in_array('admin', $this->selectedRoles, true)
        ) {
            $this->dispatch('error', message: 'Vous ne pouvez pas retirer votre propre rôle administrateur.');
            return;
        }

        // Il doit toujours rester au moins un administrateur dans le système
        $isCurrentlyAdmin = $user->hasRole('admin');
        $willStayAdmin = in_array('admin', $this->selectedRoles, true);
        $otherAdminsCount = User::role('admin')->where('id', '!=', $user->id)->count();

        if ($isCurrentlyAdmin && !$willStayAdmin && $otherAdminsCount === 0) {
            $this->dispatch('error', message: "Impossible : il doit rester au moins un administrateur actif.");
            return;
        }

        $user->syncRoles($this->selectedRoles);

        $this->dispatch('success', message: "Rôles mis à jour pour {$user->name}.");

        $this->closeRoleModal();
    }

    // =========================
    // DELETE USER
    // =========================
    public function delete($id)
    {
        if ((int) $id === (int) Auth::id()) {
            $this->dispatch('error', message: 'Vous ne pouvez pas supprimer votre propre compte.');
            return;
        }

        $user = User::findOrFail($id);

        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            $this->dispatch('error', message: 'Impossible de supprimer le dernier administrateur du système.');
            return;
        }

        $user->delete();

        $this->dispatch('success', message: 'Utilisateur supprimé avec succès.');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('matricule', 'like', '%' . $this->search . '%');
            })
            ->when($this->roleFilter, function ($query) {
                $query->role($this->roleFilter);
            })
            ->with('roles')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users,
            'totalUsers' => User::count(),
            'totalAdmins' => User::role('admin')->count(),
            'totalTeachers' => User::role('enseignant')->count(),
            'totalStudents' => User::role('student')->count(),
            'totalApparitaires' => User::role('apparitaire')->count(),
            'totalCaissiers' => User::role('caissier')->count(),
        ]);
    }
}
