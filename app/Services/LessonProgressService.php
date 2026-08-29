<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;

class LessonProgressService
{
    public function markCompleted(int $userId, Lesson $lesson): LessonProgress
    {
        return LessonProgress::firstOrCreate([
            'user_id' => $userId,
            'lesson_id' => $lesson->id,
        ], [
            'completed_at' => now(),
        ]);
    }

    public function updateEnrollmentProgress(int $userId, Course $course, Enrollment $enrollment): int
    {
        $totalLessons = $this->courseLessonsQuery($course)->count();

        $completedLessons = LessonProgress::where('user_id', $userId)
            ->whereHas('lesson.chapter.module', fn ($query) => $query->where('course_id', $course->id))
            ->count();

        $progressPercentage = $totalLessons > 0 ? (int) round(($completedLessons / $totalLessons) * 100) : 0;
        $progressPercentage = max($progressPercentage, (int) ($enrollment->progress_percentage ?? 0));

        $enrollment->update([
            'progress_percentage' => $progressPercentage,
            'status' => $progressPercentage >= 100 ? 'completed' : 'active',
        ]);

        return $progressPercentage;
    }

    public function nextLesson(Course $course, Lesson $currentLesson): ?Lesson
    {
        return $this->courseLessonsQuery($course)
            ->where(function ($query) use ($currentLesson) {
                $query->where('modules.order', '>', $currentLesson->chapter->module->order)
                    ->orWhere(function ($query) use ($currentLesson) {
                        $query->where('modules.order', $currentLesson->chapter->module->order)
                            ->where('chapters.order', '>', $currentLesson->chapter->order);
                    })
                    ->orWhere(function ($query) use ($currentLesson) {
                        $query->where('modules.order', $currentLesson->chapter->module->order)
                            ->where('chapters.order', $currentLesson->chapter->order)
                            ->where('lessons.order', '>', $currentLesson->order);
                    });
            })
            ->orderBy('modules.order')
            ->orderBy('chapters.order')
            ->orderBy('lessons.order')
            ->orderBy('lessons.id')
            ->select('lessons.*')
            ->first();
    }

    public function courseLessonsQuery(Course $course)
    {
        return Lesson::query()
            ->join('chapters', 'lessons.chapter_id', '=', 'chapters.id')
            ->join('modules', 'chapters.module_id', '=', 'modules.id')
            ->where('modules.course_id', $course->id);
    }
}
