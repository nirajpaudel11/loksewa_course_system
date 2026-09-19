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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('syllabus_pdf')->nullable()->after('description');
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->string('pdf_file')->nullable()->after('description');
            $table->longText('notes')->nullable()->after('pdf_file');
            $table->text('key_points')->nullable()->after('notes');
            $table->json('quiz_questions')->nullable()->after('key_points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['pdf_file', 'notes', 'key_points', 'quiz_questions']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('syllabus_pdf');
        });
    }
};
