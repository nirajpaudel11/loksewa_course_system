<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use App\Services\Algorithms\ContentSimilarityService;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    protected $collabService;

    protected $similarityService;

    public function __construct(
        RecommendationService $collabService,
        ContentSimilarityService $similarityService
    ) {
        $this->collabService = $collabService;
        $this->similarityService = $similarityService;
    }

    public function landing()
    {
        $courses = Course::where('is_published', true)
            ->withCount('enrollments')
            ->orderByDesc('trending_score')
            ->latest()
            ->limit(6)
            ->get();

        $stats = [
            'total_students' => $this->studentCount(),
            'total_courses' => Course::where('is_published', true)->count(),
            'total_lessons' => Lesson::where('is_published', true)->count(),
        ];

        return view('frontend.landing', [
            'courses' => $courses,
            'stats' => $stats,
        ]);
    }

    public function dashboard()
    {
        $userId = Auth::id();

        $courses = Course::where('is_published', true)
            ->latest()
            ->limit(6)
            ->get();
        $recommendations = $userId ? $this->collabService->getRecommendedCourses(Auth::user(), 5) : collect();

        // Dynamic Stats
        $stats = [
            'total_students' => $this->studentCount(),
            'total_courses' => Course::count(),
            'my_enrollments' => $userId ? Enrollment::where('user_id', $userId)->count() : 0,
        ];

        return view('frontend.dashboard', [
            'courses' => $courses,
            'recommendations' => $recommendations,
            'stats' => $stats,
        ]);
    }

    public function catalog(Request $request)
    {
        $search = $request->input('search');

        $courses = Course::where('is_published', true)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        if (Auth::guest()) {
            return view('frontend.public-catalog', compact('courses', 'search'));
        }

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
            $isEnrolled = (bool) $enrollment;
            if ($enrollment) {
                $progressPercentage = $enrollment->progress_percentage;
            }
        }

        // Algorithm 1: Collaborative Filtering – next courses for this user
        $nextRecommendations = $userId ? $this->collabService->getRecommendedCourses(Auth::user(), 5) : collect();

        // Algorithm 2: Content Similarity – related courses
        $relatedCourses = $this->similarityService->getSimilarCourses($course);

        if (Auth::guest()) {
            return view('frontend.public-course-details', [
                'course' => $course,
                'relatedCourses' => $relatedCourses,
            ]);
        }

        return view('frontend.course-details', [
            'course' => $course,
            'relatedCourses' => $relatedCourses,
            'nextRecommendations' => $nextRecommendations,
            'isEnrolled' => $isEnrolled,
            'progressPercentage' => $progressPercentage,
        ]);

    }

    public function analytics()
    {
        $userId = Auth::id();

        if (! $userId) {
            return redirect()->route('login')->with('info', 'Please sign in to view your learning analytics.');
        }

        $totalEnrollments = Enrollment::where('user_id', $userId)->count();
        $completedLessonsCount = LessonProgress::where('user_id', $userId)->count();

        $enrolledCourseIds = Enrollment::where('user_id', $userId)->pluck('course_id');
        $totalLessonsInEnrolledCourses = Lesson::whereHas('chapter.module', function ($query) use ($enrolledCourseIds) {
            $query->whereIn('course_id', $enrolledCourseIds);
        })->count();

        $completionRate = $totalLessonsInEnrolledCourses > 0
            ? round(($completedLessonsCount / $totalLessonsInEnrolledCourses) * 100)
            : 0;

        return view('frontend.analytics', [
            'totalEnrollments' => $totalEnrollments,
            'completedLessonsCount' => $completedLessonsCount,
            'completionRate' => $completionRate,
        ]);
    }

    public function visualizer()
    {
        $courses = Course::with('prerequisites')->get();

        return view('frontend.visualizer', compact('courses'));
    }

    private function studentCount(): int
    {
        return User::whereHas('roles', fn ($query) => $query->where('name', 'user'))->count();
    }
}
