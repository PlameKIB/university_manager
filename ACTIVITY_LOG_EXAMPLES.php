<?php

/**
 * EXAMPLES - Comment utiliser ActivityLog dans votre application
 * 
 * Ce fichier contient des exemples pratiques d'utilisation du système ActivityLog
 * dans différentes parties de votre application.
 */

// ============================================================================
// EXEMPLE 1: Ajouter le trait à un modèle
// ============================================================================

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use LogsActivity; // ← Ajouter cette ligne
    
    // Maintenant, toute création, modification ou suppression sera enregistrée
}

// ============================================================================
// EXEMPLE 2: Enregistrer manuellement une activité dans un contrôleur
// ============================================================================

namespace App\Http\Controllers;

use App\Services\ActivityLogService;
use App\Models\Student;

class StudentController
{
    public function __construct(private ActivityLogService $activityLog)
    {}

    public function store()
    {
        $student = Student::create([...]);

        // Enregistrer une activité personnalisée
        $this->activityLog->logCreate(
            model: 'Student',
            modelId: $student->id,
            data: $student->toArray(),
            description: 'Nouvel étudiant créé'
        );

        return redirect()->route('student.show', $student);
    }

    public function update(Student $student)
    {
        $oldValues = $student->getAttributes();
        $student->update([...]);

        // Enregistrer la modification
        $this->activityLog->logUpdate(
            model: 'Student',
            modelId: $student->id,
            oldValues: $oldValues,
            newValues: $student->getChanges(),
            description: "Profil de l'étudiant modifié"
        );

        return redirect();
    }

    public function destroy(Student $student)
    {
        $this->activityLog->logDelete(
            model: 'Student',
            modelId: $student->id,
            data: $student->toArray(),
            description: 'Étudiant supprimé'
        );

        $student->delete();
        return redirect();
    }
}

// ============================================================================
// EXEMPLE 3: Utiliser dans un composant Livewire
// ============================================================================

namespace App\Livewire\Student;

use Livewire\Component;
use App\Services\ActivityLogService;
use App\Models\Student;

class Create extends Component
{
    public $name = '';
    public $email = '';

    public function __construct(private ActivityLogService $activityLog)
    {}

    public function save()
    {
        $student = Student::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Enregistrer l'action
        $this->activityLog->logCreate(
            model: 'Student',
            modelId: $student->id,
            data: $student->toArray(),
            description: "Étudiant '{$this->name}' créé via formulaire"
        );

        session()->flash('message', 'Étudiant créé avec succès');
    }
}

// ============================================================================
// EXEMPLE 4: Enregistrer une connexion utilisateur
// ============================================================================

namespace App\Http\Controllers\Auth;

use App\Services\ActivityLogService;

class LoginController
{
    public function __construct(private ActivityLogService $activityLog)
    {}

    public function store()
    {
        // Authentifier l'utilisateur...
        auth()->attempt([...]);

        // Enregistrer la connexion
        $this->activityLog->logLogin(
            description: 'Connexion réussie'
        );

        return redirect('/dashboard');
    }
}

// ============================================================================
// EXEMPLE 5: Récupérer les activités
// ============================================================================

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityReportController
{
    public function getUserActivities($userId)
    {
        // Activités d'un utilisateur spécifique
        $activities = ActivityLog::byUser($userId)
            ->latest()
            ->paginate(20);

        return view('activity.user', compact('activities'));
    }

    public function getModelActivities($modelName)
    {
        // Toutes les activités pour un type de modèle
        $activities = ActivityLog::byModel($modelName)
            ->latest()
            ->paginate(20);

        return view('activity.model', compact('activities'));
    }

    public function getActionActivities($action)
    {
        // Toutes les activités d'un type d'action
        $activities = ActivityLog::byAction($action)
            ->latest()
            ->paginate(20);

        return view('activity.action', compact('activities'));
    }

    public function getRecentActivities()
    {
        // Les 50 dernières activités
        $activities = ActivityLog::latest()
            ->limit(50)
            ->get();

        return response()->json($activities);
    }

    public function getRecentDaysActivities($days = 7)
    {
        // Activités des N derniers jours
        $activities = ActivityLog::recentDays($days)
            ->latest()
            ->get();

        return view('activity.recent', compact('activities'));
    }
}

// ============================================================================
// EXEMPLE 6: Utiliser RecentActivities dans le dashboard
// ============================================================================

<!-- resources/views/dashboard.blade.php -->

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Autres sections du dashboard... -->
        
        <!-- Afficher les activités récentes -->
        <div class="lg:col-span-3">
            <livewire:activity-log.recent-activities />
        </div>
    </div>
@endsection

// ============================================================================
// EXEMPLE 7: Filtrer les activités avec des conditions complexes
// ============================================================================

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class AdvancedActivityController
{
    public function getComplexReport()
    {
        $activities = ActivityLog::query()
            ->where('action', '=', 'delete')
            ->whereHas('user', function ($q) {
                $q->where('role', 'admin');
            })
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->orderByDesc('created_at')
            ->get();

        // Cela récupère toutes les suppressions faites par les admins
        // au cours des 30 derniers jours

        return view('activity.delete-report', compact('activities'));
    }

    public function getUserDeletions($userId)
    {
        $deletions = ActivityLog::byUser($userId)
            ->byAction('delete')
            ->recentDays(90)
            ->with('user')
            ->get();

        return response()->json($deletions);
    }

    public function getStudentModifications()
    {
        $modifications = ActivityLog::byModel('Student')
            ->byAction('update')
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(50);

        return view('activity.student-modifications', compact('modifications'));
    }
}

// ============================================================================
// EXEMPLE 8: Nettoyer les anciens logs (Maintenance)
// ============================================================================

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class CleanOldActivityLogs extends Command
{
    protected $signature = 'activity-logs:clean {--days=90 : Nombre de jours à conserver}';

    public function handle()
    {
        $days = $this->option('days');
        
        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))
            ->delete();

        $this->info("$deleted anciens logs supprimés");
    }
}

// Utilisation: php artisan activity-logs:clean --days=90

// ============================================================================
// EXEMPLE 9: Exporter les activités en CSV
// ============================================================================

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Response;

class ExportActivityController
{
    public function exportCSV()
    {
        $activities = ActivityLog::with('user')
            ->orderByDesc('created_at')
            ->get();

        $csv = fopen('php://output', 'w');
        
        // En-tête
        fputcsv($csv, ['Date', 'Utilisateur', 'Action', 'Modèle', 'Description', 'IP']);

        // Données
        foreach ($activities as $activity) {
            fputcsv($csv, [
                $activity->created_at->format('Y-m-d H:i:s'),
                $activity->user?->name ?? 'Système',
                $activity->action,
                $activity->model,
                $activity->description,
                $activity->ip_address,
            ]);
        }

        fclose($csv);

        return Response::download('activity-logs.csv');
    }
}

// ============================================================================
// EXEMPLE 10: Consulter les modifications d'un enregistrement
// ============================================================================

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Student;

class StudentHistoryController
{
    public function showHistory(Student $student)
    {
        $history = ActivityLog::byModel('Student')
            ->where('model_id', $student->id)
            ->orderByDesc('created_at')
            ->get();

        return view('student.history', [
            'student' => $student,
            'history' => $history,
        ]);
    }
}

// resources/views/student/history.blade.php
/*
<div>
    <h2>Historique de {{ $student->name }}</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Action</th>
                <th>Par</th>
                <th>Ancienne valeur</th>
                <th>Nouvelle valeur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($history as $entry)
                <tr>
                    <td>{{ $entry->created_at }}</td>
                    <td>{{ $entry->action }}</td>
                    <td>{{ $entry->user->name }}</td>
                    <td>{{ json_encode($entry->old_values, JSON_PRETTY_PRINT) }}</td>
                    <td>{{ json_encode($entry->new_values, JSON_PRETTY_PRINT) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
*/
