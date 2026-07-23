<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generated_documents', function (Blueprint $table) {
            $table->id();

            // Code unique affiché sur le document et encodé dans le QR (ex: ATT-2026-9F3K2L)
            $table->string('code')->unique();

            // Type de document : recu, releve, attestation_frequentation, attestation_reussite, palmares
            $table->string('type');

            // Lien polymorphique vers l'objet source (Payment, Enrollment, Promotion...)
            $table->nullableMorphs('documentable');

            // Empreinte SHA-256 du contenu du document au moment de la génération
            // Permet de détecter toute falsification a posteriori
            $table->string('hash', 64);

            // Snapshot des données utilisées pour générer le document (preuve en cas de litige)
            $table->json('payload')->nullable();

            // Qui a généré le document et depuis quelle machine
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();

            // Un document peut être révoqué (ex: erreur, remplacé par une nouvelle version)
            $table->boolean('is_revoked')->default(false);
            $table->string('revoked_reason')->nullable();

            $table->timestamps();

            $table->index(['type', 'documentable_type', 'documentable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generated_documents');
    }
};
