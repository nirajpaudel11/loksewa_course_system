# Algorithm Implementation Documentation

I have successfully implemented all five requested algorithms into your Laravel platform. Below is a detailed walkthrough of how they are implemented, where the code resides, and how you can use them in your controllers and views.

---

## 1. Topological Sorting (Learning Paths)
**Where it is implemented:** `app/Services/CourseGraphService.php`

**How it works:** 
It uses **Kahn's Algorithm (Depth First Search variant)** to traverse the graph of `CoursePrerequisite` models.

**How to use it:**
When an admin tries to add a prerequisite to a course in your `AdminCurriculumController`:
```php
use App\Services\CourseGraphService;

public function storePrerequisite(Request $request, CourseGraphService $graphService) {
    if ($graphService->detectCircularDependency($request->course_id, $request->prerequisite_id)) {
        return back()->withError("Cannot add this! It creates a circular dependency loop.");
    }
    // ... save logic
}
```

---

## 2. Collaborative Filtering (Recommendations)
**Where it is implemented:** `app/Services/RecommendationService.php`

**How it works:** 
It calculates the **Jaccard Similarity** between the current user's enrollments and other users' enrollments. If two users take the same courses, they have high similarity, and the algorithm recommends the un-taken courses to each other.

**How to use it:**
On the student's dashboard or catalog page (`FrontendController`):
```php
use App\Services\RecommendationService;

public function dashboard(RecommendationService $recService) {
    $recommendedCourses = $recService->getRecommendedCourses(auth()->user(), 5);
    return view('frontend.dashboard', compact('recommendedCourses'));
}
```

---

## 3. Spaced Repetition System (SuperMemo 2)
**Where it is implemented:** `app/Services/SpacedRepetitionService.php`
**Database Change:** Added `easiness_factor`, `interval`, `repetitions`, `next_review_date` to `lesson_progress`.

**How it works:** 
When a student takes a quiz or reviews a lesson, they must rate how easy it was (0-5). The service calculates an expanding interval for when they should review it again so they never forget the material.

**How to use it:**
In your `LessonController` when a user completes a lesson/flashcard:
```php
use App\Services\SpacedRepetitionService;

public function complete(Request $request, SpacedRepetitionService $srs) {
    $progress = LessonProgress::firstOrCreate(['user_id' => auth()->id(), 'lesson_id' => $request->lesson_id]);
    
    // quality is passed from frontend buttons: 1 (Hard) to 5 (Perfect)
    $srs->calculateNextReview($progress, $request->quality); 
}
```

---

## 4. Time-Decay Ranking (Trending Courses)
**Where it is implemented:** 
- Service: `app/Services/TrendingService.php`
- Command: `app/Console/Commands/UpdateTrendingScores.php`
- DB: Added `trending_score` to `courses`.

**How it works:** 
It uses a gravity decay algorithm: `Enrollments / (AgeInHours + 2)^1.8`. Older courses need substantially more enrollments to stay on top compared to new courses.

**How to use it:**
1. Run the command manually: `php artisan courses:update-trending`
2. Schedule it in `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule) {
    $schedule->command('courses:update-trending')->hourly();
}
```
3. Fetch courses in your frontend: `$trending = Course::orderByDesc('trending_score')->get();`

---

## 5. Adaptive Pacing (Progress Prediction)
**Where it is implemented:** `app/Services/LearningPacingService.php`

**How it works:** 
It calculates the average time difference between completed lessons for a specific user (ignoring massive gaps). It then extrapolates that pace across the remaining lessons in the course.

**How to use it:**
On the user's course progress page:
```php
use App\Services\LearningPacingService;

public function courseDetails(Course $course, LearningPacingService $pacingService) {
    $predictedFinishDate = $pacingService->predictCompletionDate(auth()->user(), $course);
    
    // "You are expected to finish this course by: Dec 12, 2026"
}
```

> [!TIP]
> All services are registered with Laravel's Service Container automatically, so you can easily inject them into any Controller or Job just by type-hinting them in the constructor or method parameters!

---

## Refactoring and Security Improvements
In addition to the algorithms, the following architectural improvements were made:
1. **Hardened Authentication**: Enrollment and Lesson routes are now properly protected by the `auth` middleware, and all insecure `$userId = Auth::id() ?? 2` fallbacks have been removed.
2. **Optimized Lesson Queries**: The "Find Next Lesson" logic in `LessonController@complete` was refactored to use efficient SQL queries rather than loading and sorting all course lessons into PHP memory.
3. **Strict Validation**: The `AdminCurriculumController` now explicitly requires `content` (for text/quiz) and `attachment_path` (for video/pdf) instead of relying on brittle hardcoded fallback values.
