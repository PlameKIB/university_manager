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
            $table->string('type');

            $table->nullableMorphs('documentable');
            $table->string('hash', 64);
            $table->json('payload')->nullable();
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
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
