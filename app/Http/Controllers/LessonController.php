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

        $userId = Auth::id();

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
        $userId = Auth::id();

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


        // Find the next lesson using optimized SQL queries
        $nextLesson = \App\Models\Lesson::where('chapter_id', $lesson->chapter_id)
            ->where('order', '>', $lesson->order)
            ->orderBy('order', 'asc')
            ->first();

        if (!$nextLesson) {
            $chapter = $lesson->chapter;
            $nextChapter = \App\Models\Chapter::where('module_id', $chapter->module_id)
                ->where('order', '>', $chapter->order)
                ->orderBy('order', 'asc')
                ->first();
                
            if ($nextChapter) {
                $nextLesson = \App\Models\Lesson::where('chapter_id', $nextChapter->id)
                    ->orderBy('order', 'asc')
                    ->first();
            }
            
            if (!$nextLesson) {
                $module = $chapter->module;
                $nextModule = \App\Models\Module::where('course_id', $course->id)
                    ->where('order', '>', $module->order)
                    ->orderBy('order', 'asc')
                    ->first();
                    
                if ($nextModule) {
                    $firstChapter = \App\Models\Chapter::where('module_id', $nextModule->id)
                        ->orderBy('order', 'asc')
                        ->first();
                    if ($firstChapter) {
                        $nextLesson = \App\Models\Lesson::where('chapter_id', $firstChapter->id)
                            ->orderBy('order', 'asc')
                            ->first();
                    }
                }
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
