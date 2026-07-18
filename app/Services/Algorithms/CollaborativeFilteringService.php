<?php

namespace App\Services\Algorithms;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Collection;

class CollaborativeFilteringService
{
    /**
     * Recommend courses for a user based on enrollment patterns of similar users.
     * Uses Jaccard Similarity: |A ∩ B| / |A ∪ B|
     */
    public function getRecommendations(int $userId, int $limit = 4): Collection
    {
        $currentUserEnrollments = Enrollment::where('user_id', $userId)->pluck('course_id')->toArray();
        
        if (empty($currentUserEnrollments)) {
            // Cold start: return most popular courses if user has no enrollments
            return Course::withCount('enrollments')
                ->orderBy('enrollments_count', 'desc')
                ->limit($limit)
                ->get();
        }

        $otherUsers = User::where('id', '!=', $userId)->get();
        $similarities = [];

        foreach ($otherUsers as $otherUser) {
            $otherUserEnrollments = Enrollment::where('user_id', $otherUser->id)->pluck('course_id')->toArray();
            
            if (empty($otherUserEnrollments)) continue;

            $intersection = array_intersect($currentUserEnrollments, $otherUserEnrollments);
            $union = array_unique(array_merge($currentUserEnrollments, $otherUserEnrollments));
            
            $similarity = count($intersection) / count($union);
            
            if ($similarity > 0) {
                $similarities[$otherUser->id] = $similarity;
            }
        }

        arsort($similarities);
        $topSimilarUsers = array_keys(array_slice($similarities, 0, 5, true));

        $recommendedCourseIds = Enrollment::whereIn('user_id', $topSimilarUsers)
            ->whereNotIn('course_id', $currentUserEnrollments)
            ->groupBy('course_id')
            ->selectRaw('course_id, count(*) as count')
            ->orderBy('count', 'desc')
            ->limit($limit)
            ->pluck('course_id');

        return Course::whereIn('id', $recommendedCourseIds)->get();
    }
}
