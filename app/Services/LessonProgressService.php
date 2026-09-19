<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Support\Collection;

class LessonProgressService
{
    public function markCompleted(int $userId, Lesson $lesson): LessonProgress
    {
        $progress = LessonProgress::firstOrNew([
            'user_id' => $userId,
            'lesson_id' => $lesson->id,
        ]);

        if (! $progress->completed_at) {
            $progress->completed_at = now();
        }
        $progress->save();

        // Refresh learning pacing algorithm metrics for this user immediately
        $user = User::find($userId);
        $course = $lesson->course;
        if ($user && $course) {
            app(LearningPacingService::class)->predictCompletionDate($user, $course);
        }

        return $progress;
    }

    public function updateEnrollmentProgress(int $userId, Course $course, Enrollment $enrollment): int
    {
        $courseLessonIds = $course->lessons()->pluck('lessons.id');
        $totalLessons = $courseLessonIds->count();

        $completedLessons = LessonProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $courseLessonIds)
            ->whereNotNull('completed_at')
            ->count();

        $progressPercentage = $totalLessons > 0 ? (int) round(($completedLessons / $totalLessons) * 100) : 0;

        $newStatus = $enrollment->status;
        if ($progressPercentage >= 100) {
            $newStatus = 'completed';
        } elseif ($enrollment->status === 'completed' && $progressPercentage < 100) {
            $newStatus = 'active';
        }

        $enrollment->update([
            'progress_percentage' => $progressPercentage,
            'status' => $newStatus,
        ]);

        // Refresh pacing calculation when enrollment progress updates
        $user = User::find($userId);
        if ($user) {
            app(LearningPacingService::class)->predictCompletionDate($user, $course);
        }

        return $progressPercentage;
    }

    public function getOrderedLessons(Course $course): Collection
    {
        $ordered = collect();
        $modules = $course->modules()->orderBy('order')->orderBy('id')->get();

        foreach ($modules as $module) {
            $chapters = $module->chapters()->orderBy('order')->orderBy('id')->get();
            if ($chapters->isNotEmpty()) {
                foreach ($chapters as $chapter) {
                    $chapterLessons = $chapter->lessons()->orderBy('order')->orderBy('id')->get();
                    foreach ($chapterLessons as $l) {
                        $ordered->push($l);
                    }
                }
            }

            $directLessons = $module->lessons()->whereNull('chapter_id')->orderBy('order')->orderBy('id')->get();
            foreach ($directLessons as $l) {
                $ordered->push($l);
            }
        }

        // Fallback if lessons are attached directly
        if ($ordered->isEmpty()) {
            $ordered = $course->lessons()->orderBy('lessons.order')->orderBy('lessons.id')->get();
        }

        return $ordered;
    }

    public function isLessonUnlocked(int $userId, Course $course, Lesson $targetLesson): bool
    {
        $allLessons = $this->getOrderedLessons($course);
        $targetIndex = $allLessons->search(fn ($l) => $l->id === $targetLesson->id);

        if ($targetIndex === false) {
            return false;
        }

        // First lesson is always unlocked
        if ($targetIndex === 0) {
            return true;
        }

        $completedIds = LessonProgress::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id')
            ->toArray();

        // Check that all previous lessons in sequence are completed
        for ($i = 0; $i < $targetIndex; $i++) {
            $precedingLesson = $allLessons->get($i);
            if (! in_array($precedingLesson->id, $completedIds)) {
                return false;
            }
        }

        return true;
    }

    public function getUnlockedLessonIds(int $userId, Course $course): array
    {
        $allLessons = $this->getOrderedLessons($course);
        if ($allLessons->isEmpty()) {
            return [];
        }

        $completedIds = LessonProgress::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id')
            ->toArray();

        $unlockedIds = [];

        foreach ($allLessons as $lesson) {
            $unlockedIds[] = $lesson->id;
            // Once we encounter an incomplete lesson, unlock it (active lesson), then lock all subsequent
            if (! in_array($lesson->id, $completedIds)) {
                break;
            }
        }

        return $unlockedIds;
    }

    public function getEarliestIncompleteLesson(int $userId, Course $course): ?Lesson
    {
        $allLessons = $this->getOrderedLessons($course);
        if ($allLessons->isEmpty()) {
            return null;
        }

        $completedIds = LessonProgress::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id')
            ->toArray();

        foreach ($allLessons as $lesson) {
            if (! in_array($lesson->id, $completedIds)) {
                return $lesson;
            }
        }

        return $allLessons->last();
    }

    public function canCompleteLesson(int $userId, Course $course, Lesson $lesson): bool
    {
        return $this->isLessonUnlocked($userId, $course, $lesson);
    }

    public function nextLesson(Course $course, Lesson $currentLesson): ?Lesson
    {
        $allLessons = $this->getOrderedLessons($course);
        $currentIndex = $allLessons->search(fn ($l) => $l->id === $currentLesson->id);

        if ($currentIndex !== false && $currentIndex < $allLessons->count() - 1) {
            return $allLessons->get($currentIndex + 1);
        }

        return null;
    }

    public function courseLessonsQuery(Course $course)
    {
        return $course->lessons();
    }
}
