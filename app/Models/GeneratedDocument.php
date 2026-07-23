<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedDocument extends Model
{
    protected $fillable = [
        'code',
        'type',
        'documentable_type',
        'documentable_id',
        'hash',
        'payload',
        'generated_by',
        'ip_address',
        'is_revoked',
        'revoked_reason',
    ];

    protected $casts = [
        'payload' => 'array',
        'is_revoked' => 'boolean',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public const TYPES = [
        'recu' => 'Reçu de paiement',
        'releve' => 'Relevé de notes',
        'attestation_frequentation' => 'Attestation de fréquentation',
        'attestation_reussite' => 'Attestation de réussite',
        'palmares' => 'Palmarès de promotion',
    ];

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
