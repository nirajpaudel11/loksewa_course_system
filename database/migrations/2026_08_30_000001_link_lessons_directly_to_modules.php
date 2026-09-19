<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->foreignId('module_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('chapter_id')->nullable()->change();
        });

        // Copy existing module_ids from chapters to lessons
        if (Schema::hasTable('chapters')) {
            $lessons = DB::table('lessons')->get();
            foreach ($lessons as $lesson) {
                if ($lesson->chapter_id) {
                    $chapter = DB::table('chapters')->where('id', $lesson->chapter_id)->first();
                    if ($chapter && $chapter->module_id) {
                        DB::table('lessons')->where('id', $lesson->id)->update([
                            'module_id' => $chapter->module_id,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropColumn('module_id');
        });
    }
};
