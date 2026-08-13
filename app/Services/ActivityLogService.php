<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Enregistrer une activité
     */
    public function log(
        string $action,
        ?string $model = null,
        ?int $modelId = null,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Enregistrer une création
     */
    public function logCreate(string $model, int $modelId, ?array $data = null, ?string $description = null): ActivityLog
    {
        return $this->log(
            action: 'create',
            model: $model,
            modelId: $modelId,
            description: $description ?? "Created {$model}",
            newValues: $data,
        );
    }

    /**
     * Enregistrer une modification
     */
    public function logUpdate(
        string $model,
        int $modelId,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): ActivityLog {
        return $this->log(
            action: 'update',
            model: $model,
            modelId: $modelId,
            description: $description ?? "Updated {$model}",
            oldValues: $oldValues,
            newValues: $newValues,
        );
    }

    /**
     * Enregistrer une suppression
     */
    public function logDelete(string $model, int $modelId, ?array $data = null, ?string $description = null): ActivityLog
    {
        return $this->log(
            action: 'delete',
            model: $model,
            modelId: $modelId,
            description: $description ?? "Deleted {$model}",
            oldValues: $data,
        );
    }

    /**
     * Enregistrer une visualisation
     */
    public function logView(string $model, int $modelId, ?string $description = null): ActivityLog
    {
        return $this->log(
            action: 'view',
            model: $model,
            modelId: $modelId,
            description: $description ?? "Viewed {$model}",
        );
    }

    /**
     * Enregistrer une connexion
     */
    public function logLogin(?string $description = null): ActivityLog
    {
        return $this->log(
            action: 'login',
            description: $description ?? 'User logged in',
        );
    }

    /**
     * Enregistrer une déconnexion
     */
    public function logLogout(?string $description = null): ActivityLog
    {
        return $this->log(
            action: 'logout',
            description: $description ?? 'User logged out',
        );
    }

    /**
     * Obtenir les activités récentes
     */
    public function getRecent(int $limit = 50)
    {
        return ActivityLog::latest()->limit($limit)->get();
    }

    /**
     * Obtenir les activités d'un utilisateur
     */
    public function getUserActivities(int $userId, int $limit = 50)
    {
        return ActivityLog::byUser($userId)->latest()->limit($limit)->get();
    }

    /**
     * Obtenir les activités d'un modèle
     */
    public function getModelActivities(string $model, int $limit = 50)
    {
        return ActivityLog::byModel($model)->latest()->limit($limit)->get();
    }
}
