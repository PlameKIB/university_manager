<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('promotion_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('academic_year_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('credit');

            // Barème (points max) de chaque évaluation, configurable par cours
            $table->decimal('bareme_tp', 5, 2)->default(10);
            $table->decimal('bareme_interro', 5, 2)->default(20);
            $table->decimal('bareme_examen', 5, 2)->default(50);

            // Un même cours ne peut être attribué qu'une fois par promotion/année
            $table->unique(['course_id', 'promotion_id', 'academic_year_id'], 'unique_course_promotion_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_assignments');
    }
};
