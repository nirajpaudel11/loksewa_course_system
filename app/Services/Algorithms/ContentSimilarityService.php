<?php

namespace App\Services\Algorithms;

use App\Models\Course;
use Illuminate\Support\Collection;

class ContentSimilarityService
{
    /**
     * Finds courses similar to the given course based on TF-IDF analysis of titles/descriptions.
     */
    public function getSimilarCourses(Course $course, int $limit = 3): Collection
    {
        $allCourses = Course::where('id', '!=', $course->id)->get();
        $scores = [];

        $targetTokens = $this->tokenize($course->title.' '.$course->description);

        foreach ($allCourses as $otherCourse) {
            $otherTokens = $this->tokenize($otherCourse->title.' '.$otherCourse->description);
            $scores[$otherCourse->id] = $this->cosineSimilarity($targetTokens, $otherTokens);
        }

        arsort($scores);
        $topIds = array_keys(array_slice($scores, 0, $limit, true));

        $courses = Course::whereIn('id', $topIds)->get()->keyBy('id');

        return collect($topIds)
            ->map(fn ($courseId) => $courses->get($courseId))
            ->filter()
            ->values();
    }

    private function tokenize(string $text): array
    {
        // Simple tokenizer: lowercase, remove punctuation, split by space
        $clean = strtolower(preg_replace('/[^\w\s]/', '', $text));
        $tokens = explode(' ', $clean);

        return array_filter($tokens, fn ($t) => strlen($t) > 3); // ignore small words
    }

    private function cosineSimilarity(array $tokensA, array $tokensB): float
    {
        $vecA = array_count_values($tokensA);
        $vecB = array_count_values($tokensB);

        $uniqueTokens = array_unique(array_merge(array_keys($vecA), array_keys($vecB)));

        $dotProduct = 0;
        $magA = 0;
        $magB = 0;

        foreach ($uniqueTokens as $token) {
            $valA = $vecA[$token] ?? 0;
            $valB = $vecB[$token] ?? 0;

            $dotProduct += ($valA * $valB);
            $magA += ($valA ** 2);
            $magB += ($valB ** 2);
        }

        $divisor = sqrt($magA) * sqrt($magB);

        return $divisor == 0 ? 0 : $dotProduct / $divisor;
    }
}
