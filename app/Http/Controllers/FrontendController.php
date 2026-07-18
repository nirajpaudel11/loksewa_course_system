<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Services\Algorithms\CollaborativeFilteringService;
use App\Services\Algorithms\ContentSimilarityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    protected $collabService;
    protected $similarityService;

    public function __construct(
        CollaborativeFilteringService $collabService,
        ContentSimilarityService $similarityService
    ) {
        $this->collabService = $collabService;
        $this->similarityService = $similarityService;
    }

    public function dashboard()
    {
        $userId = Auth::id();
        
        $courses = Course::where('is_published', true)->get();
        $recommendations = $userId ? $this->collabService->getRecommendations($userId) : collect();
        
        // Dynamic Stats
        $stats = [
            'total_students' => User::role('user')->count(),
            'total_courses' => Course::count(),
            'my_enrollments' => $userId ? Enrollment::where('user_id', $userId)->count() : 0,
        ];

        return view('frontend.dashboard', [
            'courses' => $courses,
            'recommendations' => $recommendations,
            'stats' => $stats
        ]);
    }

    public function catalog(Request $request)
    {
        $search = $request->input('search');
        
        $courses = Course::where('is_published', true)
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('frontend.catalog', compact('courses', 'search'));
    }

    public function courseDetails($slug)
    {
        $course = Course::where('slug', $slug)
            ->with(['modules.chapters.lessons'])
            ->firstOrFail();
        
        $userId = Auth::id();
        $isEnrolled = false;
        $progressPercentage = 0;
        
        if ($userId) {
            $enrollment = Enrollment::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->first();
            $isEnrolled = (bool)$enrollment;
            if ($enrollment) {
                $progressPercentage = $enrollment->progress_percentage;
            }
        }
        
        // Algorithm 1: Collaborative Filtering – next courses for this user
        $nextRecommendations = $userId ? $this->collabService->getRecommendations($userId) : collect();

        // Algorithm 2: Content Similarity – related courses
        $relatedCourses = $this->similarityService->getSimilarCourses($course);

        return view('frontend.course-details', [
            'course'               => $course,
            'relatedCourses'       => $relatedCourses,
            'nextRecommendations'  => $nextRecommendations,
            'isEnrolled'           => $isEnrolled,
            'progressPercentage'   => $progressPercentage
        ]);

    }
    public function analytics()
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('info', 'Please sign in to view your learning analytics.');
        }

        $totalEnrollments = Enrollment::where('user_id', $userId)->count();
        $completedLessonsCount = \App\Models\LessonProgress::where('user_id', $userId)->count();
        
        $enrolledCourseIds = Enrollment::where('user_id', $userId)->pluck('course_id');
        $totalLessonsInEnrolledCourses = \App\Models\Lesson::whereHas('chapter.module', function($query) use ($enrolledCourseIds) {
            $query->whereIn('course_id', $enrolledCourseIds);
        })->count();

        $completionRate = $totalLessonsInEnrolledCourses > 0 
            ? round(($completedLessonsCount / $totalLessonsInEnrolledCourses) * 100) 
            : 0;

        return view('frontend.analytics', [
            'totalEnrollments' => $totalEnrollments,
            'completedLessonsCount' => $completedLessonsCount,
            'completionRate' => $completionRate
        ]);
    }

    public function visualizer()
    {
        $courses = Course::with('prerequisites')->get();
        return view('frontend.visualizer', compact('courses'));
    }
}
