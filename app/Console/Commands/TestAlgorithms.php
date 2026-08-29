<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\CoursePrerequisite;
use App\Services\CourseDependencyService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class TestAlgorithms extends Command
{
    protected $signature = 'test:algorithms';

    protected $description = 'Test the algorithmic graph logic for the LMS';

    public function handle(CourseDependencyService $service)
    {
        $this->info('Initializing Mock Data for Graph Testing...');

        Schema::disableForeignKeyConstraints();
        CoursePrerequisite::truncate();
        Course::truncate();
        Schema::enableForeignKeyConstraints();

        $c1 = Course::create(['title' => 'Intro to Programming', 'slug' => 'intro', 'level' => 'beginner']);
        $c2 = Course::create(['title' => 'Advanced PHP', 'slug' => 'adv-php', 'level' => 'intermediate']);
        $c3 = Course::create(['title' => 'Laravel Mastery', 'slug' => 'laravel', 'level' => 'advanced']);
        $c4 = Course::create(['title' => 'Web Design Basics', 'slug' => 'design', 'level' => 'beginner']);

        CoursePrerequisite::create(['course_id' => $c2->id, 'prerequisite_course_id' => $c1->id]);
        CoursePrerequisite::create(['course_id' => $c3->id, 'prerequisite_course_id' => $c2->id]);

        $this->info('1. Testing DAG Validation (Should be Valid)');
        if ($service->validatePrerequisites()) {
            $this->info('✔ DAG is valid. No cycles detected.');
        } else {
            $this->error('✖ DAG is invalid. Cycle detected.');
        }

        $this->info("\n2. Testing Topological Sorting (Learning Order)");
        $order = $service->getLearningOrder();
        $this->line('Strict Learning Order (IDs): '.implode(' -> ', $order));

        $this->info("\n3. Testing Unlock Logic");
        $targetCourseId = $c3->id;

        $this->line('Student tries to unlock Laravel without completing Advanced PHP...');
        $canUnlock = $service->canUnlockCourse($targetCourseId, [$c1->id]);
        if (! $canUnlock) {
            $this->info('✔ Correct! Student cannot unlock.');
        } else {
            $this->error('✖ Error! Student was allowed to unlock.');
        }

        $this->line('Student tries to unlock Laravel after completing Advanced PHP...');
        $canUnlock = $service->canUnlockCourse($targetCourseId, [$c1->id, $c2->id]);
        if ($canUnlock) {
            $this->info('✔ Correct! Student can unlock.');
        } else {
            $this->error('✖ Error! Student was blocked.');
        }

        $this->info("\n4. Testing Cycle Detection");
        CoursePrerequisite::create(['course_id' => $c1->id, 'prerequisite_course_id' => $c3->id]);

        if (! $service->validatePrerequisites()) {
            $this->info('✔ Cycle correctly detected. DAG is invalid.');
        } else {
            $this->error('✖ Error! Cycle was NOT detected.');
        }

        $this->info("\nGraph Algorithm Tests Completed.");
    }
}
