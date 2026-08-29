<?php

namespace App\Services;

use App\Models\Course;
use App\Models\LessonProgress;
use App\Models\User;
use Carbon\Carbon;

class LearningPacingService
{
    /**
     * Predicts when a user will finish a course based on their historical pace.
     */
    public function predictCompletionDate(User $user, Course $course): ?Carbon
    {
        // 1. Calculate user's average time per lesson across all courses
        $completedLessons = LessonProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->orderBy('created_at', 'asc')
            ->get();

        if ($completedLessons->count() < 3) {
            // Not enough data to predict pacing
            return null;
        }

        $totalTimeDiff = 0;
        $validIntervals = 0;

        for ($i = 1; $i < $completedLessons->count(); $i++) {
            $prev = Carbon::parse($completedLessons[$i - 1]->completed_at);
            $curr = Carbon::parse($completedLessons[$i]->completed_at);

            $diffHours = $prev->diffInHours($curr);
            // Ignore massive gaps (e.g. user took a month off) - cap at 48 hours for average calc
            if ($diffHours < 48) {
                $totalTimeDiff += $diffHours;
                $validIntervals++;
            }
        }

        $averageHoursPerLesson = $validIntervals > 0 ? ($totalTimeDiff / $validIntervals) : 24;

        // Save to user profile (Optional, we added learning_pace_multiplier to DB)
        // Baseline is 24 hours per lesson.
        $user->learning_pace_multiplier = $averageHoursPerLesson / 24;
        $user->save();

        // 2. Count remaining lessons in target course
        // (Assuming you have a method to get course lessons, we use the relationship defined earlier)
        $totalLessons = $course->lessons()->count();

        $completedInCourse = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $course->lessons()->pluck('lessons.id'))
            ->whereNotNull('completed_at')
            ->count();

        $remainingLessons = $totalLessons - $completedInCourse;

        if ($remainingLessons <= 0) {
            return Carbon::now(); // Already finished
        }

        // 3. Extrapolate finish time
        $predictedHoursRemaining = $remainingLessons * $averageHoursPerLesson;

        return Carbon::now()->addHours($predictedHoursRemaining);
    }
}
