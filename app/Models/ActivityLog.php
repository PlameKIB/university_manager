<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Obtenir l'utilisateur qui a effectué l'action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour filtrer par action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope pour filtrer par utilisateur
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope pour filtrer par modèle
     */
    public function scopeByModel($query, $model)
    {
        return $query->where('model', $model);
    }

    /**
     * Scope pour les 30 derniers jours
     */
    public function scopeRecentDays($query, $days = 30)
    {
        return $query->whereDate('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope pour trier par date décroissante
     */
    public function scopeLatest($query)
    {
        return $query->orderByDesc('created_at');
    }
}
