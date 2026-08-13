<?php

namespace App\Livewire\ActivityLog;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class ActivityLogList extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $action = '';

    #[Url]
    public $model = '';

    #[Url]
    public $user = '';

    #[Url]
    public $sort = 'created_at';

    #[Url]
    public $direction = 'desc';

    public function resetFilters()
    {
        $this->search = '';
        $this->action = '';
        $this->model = '';
        $this->user = '';
        $this->resetPage();
    }

    public function sortBy($column)
    {
        if ($this->sort === $column) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $column;
            $this->direction = 'asc';
        }
    }

    public function render()
    {
        $query = ActivityLog::query()
            ->with('user')
            ->latest('created_at');

        // Filtrer par recherche
        if ($this->search) {
            $query->where('description', 'like', "%{$this->search}%")
                ->orWhere('model', 'like', "%{$this->search}%")
                ->orWhereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
        }

        // Filtrer par action
        if ($this->action) {
            $query->where('action', $this->action);
        }

        // Filtrer par modèle
        if ($this->model) {
            $query->where('model', $this->model);
        }

        // Filtrer par utilisateur
        if ($this->user) {
            $query->where('user_id', $this->user);
        }

        // Trier
        $query->orderBy($this->sort, $this->direction);

        $activities = $query->paginate(15);

        // Récupérer les actions distinctes
        $actions = ActivityLog::distinct('action')->pluck('action')->sort();

        // Récupérer les modèles distincts
        $models = ActivityLog::distinct('model')->pluck('model')->filter()->sort();

        // Récupérer les utilisateurs distincts
        $users = \App\Models\User::whereHas('activityLogs')
            ->get()
            ->pluck('name', 'id')
            ->sort();

        return view('livewire.activity-log.activity-log-list', [
            'activities' => $activities,
            'actions' => $actions,
            'models' => $models,
            'users' => $users,
        ]);
    }
}
