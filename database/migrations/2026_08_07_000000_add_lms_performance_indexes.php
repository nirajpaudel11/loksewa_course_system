<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->index(['is_published', 'created_at']);
            $table->index('trending_score');
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->index(['course_id', 'order']);
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->index(['module_id', 'order']);
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->index(['chapter_id', 'order']);
            $table->index(['slug', 'chapter_id']);
        });

        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->index(['user_id', 'completed_at']);
            $table->index(['user_id', 'next_review_date']);
        });
    }

    public function down(): void
    {
        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'completed_at']);
            $table->dropIndex(['user_id', 'next_review_date']);
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropIndex(['chapter_id', 'order']);
            $table->dropIndex(['slug', 'chapter_id']);
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->dropIndex(['module_id', 'order']);
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->dropIndex(['course_id', 'order']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'created_at']);
            $table->dropIndex(['trending_score']);
        });
    }
};
