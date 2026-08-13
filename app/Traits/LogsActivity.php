<?php

namespace App\Traits;

use App\Services\ActivityLogService;

trait LogsActivity
{
    /**
     * Boot the trait
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            app(ActivityLogService::class)->logCreate(
                model: class_basename($model),
                modelId: $model->id,
                data: $model->getAttributes(),
                description: class_basename($model) . ' créé'
            );
        });

        static::updated(function ($model) {
            // Récupérer uniquement les attributs modifiés
            $changes = $model->getChanges();
            $original = $model->getOriginal();
            
            // Filtrer les attributs inutiles
            $oldValues = collect($original)->only(array_keys($changes))->toArray();
            
            app(ActivityLogService::class)->logUpdate(
                model: class_basename($model),
                modelId: $model->id,
                oldValues: $oldValues,
                newValues: $changes,
                description: class_basename($model) . ' modifié'
            );
        });

        static::deleted(function ($model) {
            app(ActivityLogService::class)->logDelete(
                model: class_basename($model),
                modelId: $model->id,
                data: $model->getAttributes(),
                description: class_basename($model) . ' supprimé'
            );
        });
    }
}
