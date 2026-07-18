<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show($course_slug, $lesson_slug)
    {
        $course = Course::where('slug', $course_slug)->firstOrFail();
        $lesson = Lesson::where('slug', $lesson_slug)->firstOrFail();

        $userId = Auth::id() ?? 2;

        // Ensure user is enrolled
        $isEnrolled = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->exists();

        if (!$isEnrolled) {
            return redirect()->route('courses.details', $course->slug)->with('error', 'Please enroll to access this lesson.');
        }

        // Get the syllabus for the sidebar
        $course->load(['modules.chapters.lessons']);

        // Fetch all completed lesson IDs for this user
        $completedLessonIds = \App\Models\LessonProgress::where('user_id', $userId)
            ->pluck('lesson_id')
            ->toArray();

        return view('frontend.lessons.show', [
            'course' => $course,
            'lesson' => $lesson,
            'completedLessonIds' => $completedLessonIds
        ]);
    }

    public function complete(Request $request, $course_slug, $lesson_slug)
    {
        $course = Course::where('slug', $course_slug)->firstOrFail();
        $lesson = Lesson::where('slug', $lesson_slug)->firstOrFail();
        $userId = Auth::id() ?? 2;

        // Ensure user is enrolled
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('courses.details', $course->slug)->with('error', 'Please enroll to access this lesson.');
        }

        // Mark the current lesson as completed
        \App\Models\LessonProgress::firstOrCreate([
            'user_id' => $userId,
            'lesson_id' => $lesson->id,
        ], [
            'completed_at' => now(),
        ]);

        // Recalculate course progress
        // Total lessons in this course
        $totalLessons = \App\Models\Lesson::whereHas('chapter.module', function($query) use ($course) {
            $query->where('course_id', $course->id);
        })->count();

        // Completed lessons in this course by this user
        $completedLessons = \App\Models\LessonProgress::where('user_id', $userId)
            ->whereHas('lesson.chapter.module', function($query) use ($course) {
                $query->where('course_id', $course->id);
            })->count();

        $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        // Never let progress go backwards (protects against stale / orphaned progress records)
        $progressPercentage = max($progressPercentage, (int) ($enrollment->progress_percentage ?? 0));

        // Update the enrollment progress percentage
        $enrollment->update([
            'progress_percentage' => $progressPercentage,
            'status' => $progressPercentage >= 100 ? 'completed' : 'active',
        ]);


        // Find the next lesson in the course structure
        // Order by module order, chapter order, then lesson order
        $allLessons = \App\Models\Lesson::whereHas('chapter.module', function($query) use ($course) {
            $query->where('course_id', $course->id);
        })
        ->with(['chapter.module'])
        ->get()
        ->sortBy(function($l) {
            return $l->chapter->module->order * 10000 + $l->chapter->order * 100 + $l->order;
        });

        $nextLesson = null;
        $foundCurrent = false;

        foreach ($allLessons as $l) {
            if ($foundCurrent) {
                $nextLesson = $l;
                break;
            }
            if ($l->id === $lesson->id) {
                $foundCurrent = true;
            }
        }

        if ($nextLesson) {
            return redirect()->route('lessons.show', [$course->slug, $nextLesson->slug])
                ->with('success', 'Lesson marked as completed! Next lesson started.');
        } else {
            return redirect()->route('courses.details', $course->slug)
                ->with('success', 'Congratulations! You have completed the entire ' . $course->title . ' course!');
        }
    }
}
