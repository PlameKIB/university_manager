<?php

namespace App\Livewire\Documents;

use App\Models\GeneratedDocument;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // =========================
    // FILTRES (Classer / Rechercher)
    // =========================
    public $search = '';
    public $type = '';
    public $statut = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'statut' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingStatut()
    {
        $this->resetPage();
    }

    public function revoke($id, $reason = null)
    {
        $document = GeneratedDocument::findOrFail($id);
        $document->update([
            'is_revoked' => true,
            'revoked_reason' => $reason ?: 'Révoqué par ' . auth()->user()->name,
        ]);

        $this->dispatch('success', message: 'Document révoqué avec succès.');
    }

    /**
     * Construit le nom lisible du "concerné" (étudiant, promotion, paiement...)
     * en fonction du type polymorphique documentable.
     */
    protected function subjectLabel(GeneratedDocument $document): string
    {
        return match ($document->documentable_type) {
            \App\Models\Enrollment::class => $document->documentable?->user?->name ?? '—',
            \App\Models\Promotion::class => $document->documentable?->name ?? '—',
            \App\Models\Payment::class => $document->documentable?->enrollment?->user?->name ?? '—',
            default => '—',
        };
    }

    /**
     * URL permettant de consulter / télécharger à nouveau le document
     * (les PDF ne sont pas stockés, ils sont régénérés à la demande).
     */
    public function documentUrl(GeneratedDocument $document): ?string
    {
        $id = $document->documentable_id;

        return match ($document->type) {
            'attestation_frequentation' => $id ? route('documents.attestation_frequentation', $id) : null,
            'attestation_reussite' => $id ? route('documents.attestation_reussite', $id) : null,
            'releve' => $id ? route('releve.show', $id) : null,
            'palmares' => $id ? route('documents.palmares', $id) : null,
            'recu' => $id ? route('payment.receipt', $id) : null,
            default => null,
        };
    }

    public function render()
    {
        $documents = GeneratedDocument::query()
            ->with(['generatedBy'])
            ->with(['documentable' => function ($morphTo) {
                $morphTo->morphWith([
                    \App\Models\Enrollment::class => ['user'],
                    \App\Models\Payment::class => ['enrollment.user'],
                ]);
            }])
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                        ->orWhereHasMorph('documentable', [\App\Models\Enrollment::class], function ($q) {
                            $q->whereHas('user', function ($q) {
                                $q->where('name', 'like', '%' . $this->search . '%')
                                    ->orWhere('matricule', 'like', '%' . $this->search . '%');
                            });
                        })
                        ->orWhereHasMorph('documentable', [\App\Models\Promotion::class], function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->type, fn($q) => $q->where('type', $this->type))
            ->when($this->statut === 'valide', fn($q) => $q->where('is_revoked', false))
            ->when($this->statut === 'revoque', fn($q) => $q->where('is_revoked', true))
            ->latest()
            ->paginate(15);

        // Ajoute le libellé du sujet pour chaque ligne (utilisé dans la vue)
        $documents->getCollection()->transform(function ($document) {
            $document->subject_label = $this->subjectLabel($document);
            return $document;
        });

        return view('livewire.documents.index', [
            'documents' => $documents,
            'types' => GeneratedDocument::TYPES,
            'totalDocuments' => GeneratedDocument::count(),
            'totalToday' => GeneratedDocument::whereDate('created_at', today())->count(),
            'totalRevoked' => GeneratedDocument::where('is_revoked', true)->count(),
        ]);
    }
}