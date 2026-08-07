<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use Carbon\Carbon;

class TrendingService
{
    /**
     * Calculates the trending score for all courses and updates the database.
     * Uses a HackerNews-style gravity decay algorithm.
     */
    public function calculateTrendingScores(): void
    {
        $courses = Course::all();
        $now = Carbon::now();

        foreach ($courses as $course) {
            // Count recent enrollments (e.g. in the last 30 days) to avoid completely old data dominating
            $recentEnrollments = Enrollment::where('course_id', $course->id)
                ->where('created_at', '>=', $now->copy()->subDays(30))
                ->count();
            
            // Age in hours since course creation (or publication)
            // Using created_at for this example.
            $ageInHours = $course->created_at ? $course->created_at->diffInHours($now) : 0;
            
            // Gravity parameter controls how fast a course drops. Standard is 1.8 for HN.
            $gravity = 1.8;

            // Score = (Enrollments) / (Age + 2)^Gravity
            // Adding 2 to age prevents division by zero or very high scores for brand new courses
            $score = $recentEnrollments / pow(($ageInHours + 2), $gravity);
            
            // Scale score for easier reading in DB (optional)
            $course->trending_score = $score * 10000;
            $course->save();
        }
    }
}
