<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Carbon\Carbon;

class LearningPacingService
{
    /**
     * Recalculates user's pace multiplier based on recent lesson progress history.
     */
    public function recalculateUserPace(User $user): float
    {
        $completedLessons = LessonProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'asc')
            ->get();

        if ($completedLessons->count() < 3) {
            $user->learning_pace_multiplier = 1.0;
            $user->save();

            return 1.0;
        }

        $totalTimeDiff = 0;
        $validIntervals = 0;

        for ($i = 1; $i < $completedLessons->count(); $i++) {
            $prev = Carbon::parse($completedLessons[$i - 1]->completed_at);
            $curr = Carbon::parse($completedLessons[$i]->completed_at);

            $diffHours = abs($prev->diffInHours($curr));
            // Ignore zero or massive gaps (e.g. user took a month off) - cap at 48 hours for average calc
            if ($diffHours > 0 && $diffHours < 48) {
                $totalTimeDiff += $diffHours;
                $validIntervals++;
            }
        }

        $averageHoursPerLesson = $validIntervals > 0 ? ($totalTimeDiff / $validIntervals) : 24;
        $multiplier = round($averageHoursPerLesson / 24, 2);
        if ($multiplier <= 0) {
            $multiplier = 1.0;
        }

        $user->learning_pace_multiplier = $multiplier;
        $user->save();

        return (float) $multiplier;
    }

    /**
     * Predicts when a user will finish a course based on their historical pace.
     */
    public function predictCompletionDate(User $user, Course $course, bool $forceRecalculate = false): ?Carbon
    {
        // 1. Calculate user's average time per lesson across all courses
        $completedLessons = LessonProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'asc')
            ->get();

        if ($completedLessons->count() < 3) {
            // Not enough data to predict pacing
            return null;
        }

        if ($forceRecalculate || empty($user->learning_pace_multiplier) || $user->learning_pace_multiplier <= 0) {
            $this->recalculateUserPace($user);
        }

        $averageHoursPerLesson = 24 * (float) ($user->learning_pace_multiplier ?: 1.0);

        // 2. Count remaining lessons in target course
        $courseLessonIds = $course->lessons()->pluck('lessons.id');

        $totalLessons = $courseLessonIds->count();
        if ($totalLessons === 0) {
            return null;
        }

        $completedInCourse = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $courseLessonIds)
            ->whereNotNull('completed_at')
            ->count();

        $remainingLessons = $totalLessons - $completedInCourse;

        if ($remainingLessons <= 0) {
            return Carbon::now(); // Already finished
        }

        // 3. Extrapolate finish time
        $predictedHoursRemaining = $remainingLessons * $averageHoursPerLesson;

        return Carbon::now()->addHours((int) round($predictedHoursRemaining));
    }
}
