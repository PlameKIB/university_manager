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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_assignment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete(); //Pour l'etudiant

            $table->decimal('tp', 5, 2)->nullable();
            $table->decimal('interro', 5, 2)->nullable();
            $table->decimal('examen', 5, 2)->nullable();

            // Une seule ligne de cotation par étudiant et par cours attribué
            $table->unique(['course_assignment_id', 'user_id'], 'unique_grade_per_student_course');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
