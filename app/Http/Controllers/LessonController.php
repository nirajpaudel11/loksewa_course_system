<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
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
            ->with(['modules.chapters.lessons'])
            ->firstOrFail();

        $lesson = Lesson::where('slug', $lesson_slug)
            ->whereHas('chapter.module', fn ($query) => $query->where('course_id', $course->id))
            ->with('chapter.module')
            ->firstOrFail();

        $userId = Auth::id();

        // Ensure user is enrolled
        $isEnrolled = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->exists();

        if (! $isEnrolled) {
            return redirect()->route('courses.details', $course->slug)->with('error', 'Please enroll to access this lesson.');
        }

        // Fetch all completed lesson IDs for this user
        $completedLessonIds = LessonProgress::where('user_id', $userId)
            ->pluck('lesson_id')
            ->toArray();

        return view('frontend.lessons.show', [
            'course' => $course,
            'lesson' => $lesson,
            'completedLessonIds' => $completedLessonIds,
        ]);
    }

    public function complete(Request $request, $course_slug, $lesson_slug)
    {
        $course = Course::where('slug', $course_slug)->firstOrFail();
        $lesson = Lesson::where('slug', $lesson_slug)
            ->whereHas('chapter.module', fn ($query) => $query->where('course_id', $course->id))
            ->with('chapter.module')
            ->firstOrFail();
        $userId = Auth::id();

        // Ensure user is enrolled
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return redirect()->route('courses.details', $course->slug)->with('error', 'Please enroll to access this lesson.');
        }

        $this->lessonProgressService->markCompleted($userId, $lesson);
        $this->lessonProgressService->updateEnrollmentProgress($userId, $course, $enrollment);
        $nextLesson = $this->lessonProgressService->nextLesson($course, $lesson);

        if ($nextLesson) {
            return redirect()->route('lessons.show', [$course->slug, $nextLesson->slug])
                ->with('success', 'Lesson marked as completed! Next lesson started.');
        } else {
            return redirect()->route('courses.details', $course->slug)
                ->with('success', 'Congratulations! You have completed the entire '.$course->title.' course!');
        }
    }
}
