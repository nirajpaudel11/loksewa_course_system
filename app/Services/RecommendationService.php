<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Collection;

class RecommendationService
{
    /**
     * Recommends courses based on Collaborative Filtering (Jaccard Similarity).
     */
    public function getRecommendedCourses(User $user, int $limit = 5): Collection
    {
        $userEnrollments = Enrollment::where('user_id', $user->id)->pluck('course_id')->toArray();

        if (empty($userEnrollments)) {
            // Cold start: Recommend top trending courses
            return Course::orderByDesc('trending_score')->limit($limit)->get();
        }

        // Get other users who have enrolled in the same courses
        $similarUsers = Enrollment::whereIn('course_id', $userEnrollments)
            ->where('user_id', '!=', $user->id)
            ->pluck('user_id')
            ->unique();

        $courseScores = [];

        foreach ($similarUsers as $similarUserId) {
            $similarUserEnrollments = Enrollment::where('user_id', $similarUserId)->pluck('course_id')->toArray();
            
            // Calculate Jaccard Similarity: |Intersection| / |Union|
            $intersection = array_intersect($userEnrollments, $similarUserEnrollments);
            $union = array_unique(array_merge($userEnrollments, $similarUserEnrollments));
            
            $similarity = count($intersection) / count($union);

            // Add weight to courses the similar user took that our user hasn't
            $newCourses = array_diff($similarUserEnrollments, $userEnrollments);
            foreach ($newCourses as $courseId) {
                if (!isset($courseScores[$courseId])) {
                    $courseScores[$courseId] = 0;
                }
                $courseScores[$courseId] += $similarity;
            }
        }

        // Sort by highest score
        arsort($courseScores);
        
        $recommendedCourseIds = array_slice(array_keys($courseScores), 0, $limit);
        
        // Return course objects maintaining the sorted order
        if (empty($recommendedCourseIds)) {
            return collect();
        }
        
        $placeholders = implode(',', array_fill(0, count($recommendedCourseIds), '?'));
        return Course::whereIn('id', $recommendedCourseIds)
            ->orderByRaw("FIELD(id, $placeholders)", $recommendedCourseIds)
            ->get();
    }
}
