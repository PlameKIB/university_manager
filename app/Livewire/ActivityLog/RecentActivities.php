<?php

namespace App\Livewire\ActivityLog;

use App\Models\ActivityLog;
use Livewire\Component;

class RecentActivities extends Component
{
    public $limit = 10;

    #[\Livewire\Attributes\On('activity-logged')]
    public function refresh()
    {
        // Rafraîchir quand une nouvelle activité est enregistrée
    }

    public function render()
    {
        $activities = ActivityLog::with('user')
            ->latest('created_at')
            ->limit($this->limit)
            ->get();

        return view('livewire.activity-log.recent-activities', [
            'activities' => $activities,
        ]);
    }
}
