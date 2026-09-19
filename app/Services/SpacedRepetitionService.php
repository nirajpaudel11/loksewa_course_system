<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Lesson;
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
     * Record review response quality for a user on a given lesson.
     */
    public function recordReviewResponse(User $user, Lesson $lesson, int $quality): LessonProgress
    {
        $progress = LessonProgress::firstOrNew([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
        ]);

        if (! $progress->exists) {
            $progress->completed_at = Carbon::now();
            $progress->easiness_factor = 2.50;
            $progress->repetitions = 0;
            $progress->interval = 1;
        }

        return $this->calculateNextReview($progress, $quality);
    }

    /**
     * Get lessons due for review today.
     */
    public function getDueReviews(User $user): Collection
    {
        return LessonProgress::where('user_id', $user->id)
            ->whereNotNull('next_review_date')
            ->where('next_review_date', '<=', Carbon::now())
            ->with(['lesson.module.course', 'lesson.chapter.module.course'])
            ->get();
    }

    /**
     * Extract 1 representative MCQ from a lesson and format it as a review flashcard.
     */
    public function extractFlashcardFromLesson(Lesson $lesson, ?LessonProgress $progress = null): array
    {
        $questions = $lesson->quiz_questions;
        $mcq = null;

        if (is_array($questions) && count($questions) > 0) {
            $mcq = $questions[0];
        } elseif (is_string($questions) && ! empty(trim($questions))) {
            $decoded = json_decode($questions, true);
            if (is_array($decoded) && count($decoded) > 0) {
                $mcq = $decoded[0];
            }
        }

        if (! $mcq || ! isset($mcq['question']) || empty($mcq['question'])) {
            $mcq = [
                'question' => "What is the core conceptual focus and administrative importance of '{$lesson->title}' in the Loksewa syllabus?",
                'options' => [
                    'Mastery of constitutional provisions, statutory frameworks, and administrative procedures',
                    'Theoretical definitions with no practical governance application',
                    'Historical trivia outside the civil service scope',
                    'None of the above',
                ],
                'answer' => 0,
                'explanation' => "Understanding '{$lesson->title}' provides fundamental knowledge and high-yield scoring clarity for Loksewa competitive examinations.",
            ];
        }

        $answerIndex = is_numeric($mcq['answer'] ?? null) ? (int) $mcq['answer'] : 0;
        $options = $mcq['options'] ?? [
            'Mastery of key provisions',
            'Secondary theoretical background',
            'Non-applicable guidelines',
            'None of the above',
        ];

        // Ensure at least 4 options
        while (count($options) < 4) {
            $options[] = 'Not applicable';
        }

        $correctText = $options[$answerIndex] ?? ($options[0] ?? 'Correct answer');
        $course = $lesson->course;
        $module = $lesson->module ?? $lesson->chapter?->module;

        $isDue = false;
        if ($progress && $progress->next_review_date) {
            $isDue = Carbon::parse($progress->next_review_date)->isPast() || Carbon::parse($progress->next_review_date)->isToday();
        }

        return [
            'lesson_id' => $lesson->id,
            'lesson_title' => $lesson->title,
            'lesson_slug' => $lesson->slug,
            'module_id' => $module?->id,
            'module_title' => $module?->title ?? 'Curriculum Module',
            'course_id' => $course?->id,
            'course_title' => $course?->title ?? 'Loksewa Course',
            'course_slug' => $course?->slug ?? '',
            'question' => $mcq['question'],
            'options' => $options,
            'answer_index' => $answerIndex,
            'correct_text' => $correctText,
            'explanation' => $mcq['explanation'] ?? 'High-yield Loksewa exam retention concept.',
            'interval' => $progress?->interval ?? 1,
            'repetitions' => $progress?->repetitions ?? 0,
            'easiness_factor' => (float) ($progress?->easiness_factor ?? 2.50),
            'next_review_date' => $progress?->next_review_date ? Carbon::parse($progress->next_review_date)->format('Y-m-d') : null,
            'next_review_human' => $progress?->next_review_date ? Carbon::parse($progress->next_review_date)->diffForHumans() : 'Unreviewed',
            'is_due' => $isDue,
        ];
    }

    /**
     * Extract 1 MCQ from each lesson of a course to generate flashcards.
     */
    public function extractFlashcardsForCourse(Course $course, ?User $user = null, bool $onlyDue = false): Collection
    {
        $lessons = Lesson::where(function ($query) use ($course) {
            $query->whereHas('module', fn ($q) => $q->where('course_id', $course->id))
                ->orWhereHas('chapter.module', fn ($q) => $q->where('course_id', $course->id));
        })
            ->where('is_published', true)
            ->orderBy('order')
            ->get();

        $progresses = collect();
        if ($user) {
            $progresses = LessonProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $lessons->pluck('id'))
                ->get()
                ->keyBy('lesson_id');
        }

        $flashcards = collect();
        foreach ($lessons as $lesson) {
            $prog = $progresses->get($lesson->id);
            $card = $this->extractFlashcardFromLesson($lesson, $prog);

            if ($onlyDue && ! $card['is_due']) {
                continue;
            }

            $flashcards->push($card);
        }

        return $flashcards;
    }

    /**
     * Group due reviews by course, attaching extracted flashcards for each course.
     */
    public function getDueCoursesWithFlashcards(User $user): Collection
    {
        $dueProgresses = $this->getDueReviews($user);

        return $dueProgresses->groupBy(function ($prog) {
            $course = $prog->lesson?->course;

            return $course?->id ?? 0;
        })->filter(fn ($group, $courseId) => $courseId > 0)->map(function ($group) {
            $firstProgress = $group->first();
            $course = $firstProgress->lesson?->course;

            $flashcards = $group->map(function ($prog) {
                return $this->extractFlashcardFromLesson($prog->lesson, $prog);
            });

            return [
                'course' => $course,
                'due_count' => $group->count(),
                'due_progresses' => $group,
                'flashcards' => $flashcards,
            ];
        })->values();
    }
}
