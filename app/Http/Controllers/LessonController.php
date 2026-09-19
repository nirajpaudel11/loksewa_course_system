<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Services\LearningPacingService;
use App\Services\LessonProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function __construct(
        protected LessonProgressService $lessonProgressService
    ) {}

    public function show($course_slug, $lesson_slug)
    {
        $course = Course::where('slug', $course_slug)
            ->with(['modules.lessons'])
            ->firstOrFail();

        $lesson = Lesson::where('slug', $lesson_slug)
            ->where(function ($query) use ($course) {
                $query->whereHas('module', fn ($q) => $q->where('course_id', $course->id))
                    ->orWhereHas('chapter.module', fn ($q) => $q->where('course_id', $course->id));
            })
            ->first();

        // Resilient fallback: If not found by exact slug, find best matching lesson in course and redirect
        if (! $lesson) {
            $cleaned = preg_replace('/-(diplomacy|treaties|quiz|\d+)$/', '', $lesson_slug);
            if (! empty($cleaned) && $cleaned !== $lesson_slug) {
                $lesson = Lesson::where(function ($query) use ($course) {
                    $query->whereHas('module', fn ($q) => $q->where('course_id', $course->id))
                        ->orWhereHas('chapter.module', fn ($q) => $q->where('course_id', $course->id));
                })->where(function ($q) use ($cleaned) {
                    $q->where('slug', 'LIKE', '%'.$cleaned.'%')
                        ->orWhere('title', 'LIKE', '%'.str_replace('-', ' ', $cleaned).'%');
                })->first();
            }

            if (! $lesson) {
                $keywords = array_values(array_filter(
                    preg_split('/[^a-zA-Z]+/', $lesson_slug),
                    fn ($w) => strlen($w) >= 4 && ! in_array(strtolower($w), ['quiz', 'test', 'exam', 'part', 'paper', 'course', 'lesson', 'with', 'from', 'that', 'this'])
                ));

                if (! empty($keywords)) {
                    $courseLessons = Lesson::where(function ($query) use ($course) {
                        $query->whereHas('module', fn ($q) => $q->where('course_id', $course->id))
                            ->orWhereHas('chapter.module', fn ($q) => $q->where('course_id', $course->id));
                    })->get();

                    $bestMatch = null;
                    $highestScore = 0;

                    foreach ($courseLessons as $candidate) {
                        $candidateText = strtolower($candidate->title.' '.$candidate->slug);
                        $score = 0;
                        foreach ($keywords as $kw) {
                            if (str_contains($candidateText, strtolower($kw))) {
                                $score++;
                            }
                        }

                        if ($score > $highestScore) {
                            $highestScore = $score;
                            $bestMatch = $candidate;
                        }
                    }

                    if ($bestMatch && ($highestScore >= 2 || (count($keywords) === 1 && $highestScore >= 1))) {
                        $lesson = $bestMatch;
                    }
                }
            }

            if ($lesson) {
                return redirect()->route('lessons.show', ['course_slug' => $course->slug, 'lesson_slug' => $lesson->slug]);
            }

            abort(404, 'Lesson not found.');
        }

        $userId = Auth::id();

        // Ensure user is enrolled and verified by admin
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return redirect()->route('courses.details', $course->slug)->with('error', 'Please enroll to access this lesson.');
        }

        if ($enrollment->status === 'pending') {
            return redirect()->route('courses.details', $course->slug)
                ->with('warning', 'Your enrollment is pending administrator verification. Lesson materials will be unlocked once approved.');
        }

        if ($enrollment->status === 'rejected') {
            return redirect()->route('courses.details', $course->slug)
                ->with('error', 'Your enrollment request was not approved by the administrator.');
        }

        // Fetch all completed lesson IDs for this user
        $completedLessonIds = LessonProgress::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id')
            ->toArray();

        // Enforce sequential learning: verify if this lesson is unlocked
        if (! $this->lessonProgressService->isLessonUnlocked($userId, $course, $lesson)) {
            $earliestIncomplete = $this->lessonProgressService->getEarliestIncompleteLesson($userId, $course);
            if ($earliestIncomplete && $earliestIncomplete->id !== $lesson->id) {
                return redirect()->route('lessons.show', ['course_slug' => $course->slug, 'lesson_slug' => $earliestIncomplete->slug])
                    ->with('warning', 'Please complete "'.$earliestIncomplete->title.'" before proceeding to subsequent lessons.');
            }
        }

        $unlockedLessonIds = $this->lessonProgressService->getUnlockedLessonIds($userId, $course);
        $user = Auth::user();
        $predictedCompletion = $user ? app(LearningPacingService::class)->predictCompletionDate($user, $course) : null;

        return view('frontend.lessons.show', [
            'course' => $course,
            'lesson' => $lesson,
            'completedLessonIds' => $completedLessonIds,
            'unlockedLessonIds' => $unlockedLessonIds,
            'predictedCompletion' => $predictedCompletion,
            'paceMultiplier' => $user->learning_pace_multiplier ?? 1.0,
        ]);
    }

    public function complete(Request $request, $course_slug, $lesson_slug)
    {
        $course = Course::where('slug', $course_slug)->firstOrFail();
        $lesson = Lesson::where('slug', $lesson_slug)
            ->where(function ($query) use ($course) {
                $query->whereHas('module', fn ($q) => $q->where('course_id', $course->id))
                    ->orWhereHas('chapter.module', fn ($q) => $q->where('course_id', $course->id));
            })
            ->firstOrFail();
        $userId = Auth::id();

        // Ensure user is enrolled and verified
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return redirect()->route('courses.details', $course->slug)->with('error', 'Please enroll to access this lesson.');
        }

        if ($enrollment->status !== 'active' && $enrollment->status !== 'completed') {
            return redirect()->route('courses.details', $course->slug)
                ->with('warning', 'Admin verification is required before saving lesson progress.');
        }

        // Prevent random or out-of-order completion: all preceding lessons must be completed first
        if (! $this->lessonProgressService->canCompleteLesson($userId, $course, $lesson)) {
            $earliestIncomplete = $this->lessonProgressService->getEarliestIncompleteLesson($userId, $course);

            return redirect()->route('lessons.show', [$course->slug, $earliestIncomplete ? $earliestIncomplete->slug : $lesson->slug])
                ->with('warning', 'You cannot complete lessons out of order. Please complete prior lessons first.');
        }

        // Validate quiz completion if lesson contains practice questions
        $hasQuiz = ! empty($lesson->quiz_questions) && is_array($lesson->quiz_questions) && count($lesson->quiz_questions) > 0;
        if (! $hasQuiz && ! empty($lesson->content)) {
            $decoded = json_decode($lesson->content, true);
            if (is_array($decoded) && isset($decoded[0]['question'])) {
                $hasQuiz = true;
            }
        }

        if ($hasQuiz && ! $request->boolean('quiz_completed')) {
            return redirect()->route('lessons.show', [$course->slug, $lesson->slug])
                ->with('warning', 'You must complete the practice quiz before this lesson can be marked as completed.');
        }

        $this->lessonProgressService->markCompleted($userId, $lesson);
        $this->lessonProgressService->updateEnrollmentProgress($userId, $course, $enrollment);
        $nextLesson = $this->lessonProgressService->nextLesson($course, $lesson);

        if ($nextLesson) {
            return redirect()->route('lessons.show', [$course->slug, $nextLesson->slug])
                ->with('success', 'Lesson and quiz completed! Next lesson started.');
        } else {
            return redirect()->route('courses.details', $course->slug)
                ->with('success', 'Congratulations! You have completed the entire '.$course->title.' course!');
        }
    }
}
