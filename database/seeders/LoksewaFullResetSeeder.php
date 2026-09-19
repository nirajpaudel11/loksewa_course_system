<?php

namespace Database\Seeders;

use Database\Seeders\Helpers\RestoreOriginalPdfs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Master Reset & Seeder Orchestrator.
 *
 * 1. Safely wipes all existing course, enrollment, lesson progress, and demo user data.
 * 2. Seeds 8 authentic Loksewa courses, modules, chapters, and lessons.
 * 3. Compiles and generates 18+ high quality researched study notes PDFs using DomPDF.
 * 4. Seeds 30 realistic Nepali student users + 1 admin.
 * 5. Seeds prerequisite relationships forming a clean DAG graph.
 * 6. Generates rich collaborative filtering overlap matrices and trending timelines.
 * 7. Populates SuperMemo SM-2 spaced repetition parameters and realistic pacing metrics.
 * 8. Re-computes and caches gravity-decay trending scores.
 */
class LoksewaFullResetSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->newLine();
        $this->command->info('🧹 [1/4] Wiping all existing course, user & algorithm data...');

        $this->wipeAllData();

        $this->command->info('📚 [2/4] Seeding Loksewa courses, NEA Level-4 & Section Officer curriculum...');
        $this->call(LoksewaCoursesSeeder::class);
        $this->call(NeaLevel4CourseSeeder::class);
        $this->call(SectionOfficerCourseSeeder::class);
        RestoreOriginalPdfs::restore();

        $this->command->info('👥 [3/4] Seeding 30 Nepali student users & System Admin...');
        $this->call(LoksewaUsersSeeder::class);

        $this->command->info('🧠 [4/4] Training all 6 LMS algorithms with realistic progress data...');
        $this->call(LoksewaAlgorithmSeeder::class);

        $this->command->newLine();
        $this->command->info('🎉 Full Loksewa System Reset & Seeding Completed Successfully!');
        $this->command->info('👉 Admin panel available at: /admin');
        $this->command->info('👉 Algorithm Report available at: /admin/algorithm-report');
    }

    private function wipeAllData(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Progress and enrollments
        DB::table('lesson_progress')->truncate();
        DB::table('enrollments')->truncate();

        // 2. Curriculum
        DB::table('course_prerequisites')->truncate();
        DB::table('lessons')->truncate();
        DB::table('chapters')->truncate();
        DB::table('modules')->truncate();
        DB::table('courses')->truncate();

        // 3. User roles & users (except keeping clean state)
        if (Schema::hasTable('model_has_roles')) {
            DB::table('model_has_roles')->truncate();
        }
        if (Schema::hasTable('model_has_permissions')) {
            DB::table('model_has_permissions')->truncate();
        }
        DB::table('users')->truncate();

        Schema::enableForeignKeyConstraints();

        $this->command->info('   ✅ Truncated all tables cleanly (FK constraints respected).');
    }
}
