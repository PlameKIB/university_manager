<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action'); // create, update, delete, view, login, logout
            $table->string('model')->nullable(); // Nom du modèle (User, Course, etc.)
            $table->unsignedBigInteger('model_id')->nullable(); // ID de l'enregistrement modifié
            $table->text('description')->nullable(); // Description de l'action
            $table->text('old_values')->nullable(); // Anciennes valeurs (JSON)
            $table->text('new_values')->nullable(); // Nouvelles valeurs (JSON)
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            // Index pour les recherches rapides
            $table->index('user_id');
            $table->index('action');
            $table->index('model');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
