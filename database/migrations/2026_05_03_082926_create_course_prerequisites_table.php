<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_prerequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete(); // The course that requires the prerequisite
            $table->foreignId('prerequisite_course_id')->constrained('courses')->cascadeOnDelete(); // The required course
            $table->timestamps();

            // Prevent duplicate prerequisites
            $table->unique(['course_id', 'prerequisite_course_id'], 'course_prerequisite_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_prerequisites');
    }
};
