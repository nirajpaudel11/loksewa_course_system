<?php

namespace App\Services;

use App\Models\LessonProgress;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SpacedRepetitionService
{
    /**
     * Updates the spaced repetition metrics for a lesson using SuperMemo 2 (SM-2) algorithm.
     * Quality: 0 (Blackout) to 5 (Perfect response)
     */
    public function calculateNextReview(LessonProgress $progress, int $qualityOfResponse): LessonProgress
    {
        $qualityOfResponse = max(0, min(5, $qualityOfResponse));

        if ($qualityOfResponse < 3) {
            // Failed, reset repetitions
            $progress->repetitions = 0;
            $progress->interval = 1;
        } else {
            // Passed, increase repetitions and interval
            $progress->repetitions += 1;

            if ($progress->repetitions == 1) {
                $progress->interval = 1;
            } elseif ($progress->repetitions == 2) {
                $progress->interval = 6;
            } else {
                $progress->interval = (int) round($progress->interval * $progress->easiness_factor);
            }
        }

        // Calculate new easiness factor
        $progress->easiness_factor = $progress->easiness_factor + (0.1 - (5 - $qualityOfResponse) * (0.08 + (5 - $qualityOfResponse) * 0.02));
        if ($progress->easiness_factor < 1.3) {
            $progress->easiness_factor = 1.3;
        }

        $progress->next_review_date = Carbon::now()->addDays($progress->interval);
        $progress->save();

        return $progress;
    }

    /**
     * Get lessons due for review today.
     */
    public function getDueReviews(User $user): Collection
    {
        return LessonProgress::where('user_id', $user->id)
            ->whereNotNull('next_review_date')
            ->where('next_review_date', '<=', Carbon::now())
            ->with('lesson')
            ->get();
    }
}
