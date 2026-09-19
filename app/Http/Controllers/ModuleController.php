<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Module;
use App\Services\LearningPacingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function show($course_slug, $module_slug)
    {
        $course = Course::where('slug', $course_slug)
            ->with(['modules' => fn ($q) => $q->orderBy('order')])
            ->firstOrFail();

        $module = Module::where('slug', $module_slug)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $userId = Auth::id();

        // Check authentication and enrollment
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return redirect()->route('courses.details', $course->slug)
                ->with('error', 'Please enroll in this course to access module materials.');
        }

        if ($enrollment->status === 'pending') {
            return redirect()->route('courses.details', $course->slug)
                ->with('warning', 'Your enrollment is pending administrator verification. Module materials will be unlocked once approved.');
        }

        if ($enrollment->status === 'rejected') {
            return redirect()->route('courses.details', $course->slug)
                ->with('error', 'Your enrollment was not approved by the administrator.');
        }

        // If module has lessons, navigate directly to the 1st lesson
        $firstLesson = $module->lessons()->orderBy('order')->first();
        if ($firstLesson) {
            return redirect()->route('lessons.show', [$course->slug, $firstLesson->slug]);
        }

        // Resolve Course-Level Syllabus PDF URL
        $courseSyllabusUrl = null;
        if (! empty($course->syllabus_pdf)) {
            $courseSyllabusUrl = $this->resolveFileUrl($course->syllabus_pdf);
        }

        // Resolve Module / Lesson PDF URL (prioritizing uploaded lesson PDFs)
        $primaryPdfLesson = $module->lessons()->whereNotNull('attachment_path')->where('attachment_path', '!=', '')->orderBy('order')->first();
        $modulePdfUrl = null;
        if ($primaryPdfLesson && ! empty($primaryPdfLesson->attachment_path)) {
            $modulePdfUrl = $this->resolveFileUrl($primaryPdfLesson->attachment_path);
        } elseif (! empty($module->pdf_file)) {
            $modulePdfUrl = $this->resolveFileUrl($module->pdf_file);
        }

        // Format quiz questions
        $quizQuestions = [];
        if (! empty($module->quiz_questions)) {
            $raw = is_string($module->quiz_questions) ? json_decode($module->quiz_questions, true) : $module->quiz_questions;
            if (is_array($raw)) {
                foreach ($raw as $q) {
                    if (empty(trim($q['question'] ?? ''))) {
                        continue;
                    }
                    $quizQuestions[] = [
                        'question' => $q['question'] ?? '',
                        'options' => [
                            $q['option_0'] ?? ($q['options'][0] ?? ''),
                            $q['option_1'] ?? ($q['options'][1] ?? ''),
                            $q['option_2'] ?? ($q['options'][2] ?? ''),
                            $q['option_3'] ?? ($q['options'][3] ?? ''),
                        ],
                        'answer' => (int) ($q['answer'] ?? 0),
                        'hint' => $q['hint'] ?? '',
                        'explanation' => $q['explanation'] ?? '',
                    ];
                }
            }
        }

        // Navigation (Next / Previous module)
        $allModules = $course->modules;
        $currentIndex = $allModules->search(fn ($m) => $m->id === $module->id);
        $prevModule = $currentIndex > 0 ? $allModules->get($currentIndex - 1) : null;
        $nextModule = ($currentIndex !== false && $currentIndex < $allModules->count() - 1) ? $allModules->get($currentIndex + 1) : null;

        $user = Auth::user();
        $predictedCompletion = $user ? app(LearningPacingService::class)->predictCompletionDate($user, $course) : null;

        return view('frontend.modules.show', [
            'course' => $course,
            'module' => $module,
            'allModules' => $allModules,
            'prevModule' => $prevModule,
            'nextModule' => $nextModule,
            'courseSyllabusUrl' => $courseSyllabusUrl,
            'modulePdfUrl' => $modulePdfUrl,
            'primaryPdfLesson' => $primaryPdfLesson,
            'quizQuestions' => $quizQuestions,
            'enrollment' => $enrollment,
            'predictedCompletion' => $predictedCompletion,
            'paceMultiplier' => $user->learning_pace_multiplier ?? 1.0,
        ]);
    }

    public function complete(Request $request, $course_slug, $module_slug)
    {
        $course = Course::where('slug', $course_slug)->firstOrFail();
        $module = Module::where('slug', $module_slug)->where('course_id', $course->id)->firstOrFail();
        $userId = Auth::id();

        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment || ! in_array($enrollment->status, ['active', 'completed'])) {
            return redirect()->route('courses.details', $course->slug)
                ->with('error', 'Active enrollment required.');
        }

        $allModules = $course->modules()->orderBy('order')->get();
        $currentIndex = $allModules->search(fn ($m) => $m->id === $module->id);
        $totalModules = $allModules->count();

        if ($totalModules > 0) {
            $newProgress = (int) round((($currentIndex + 1) / $totalModules) * 100);
            $enrollment->progress_percentage = min(100, max($enrollment->progress_percentage, $newProgress));
            if ($enrollment->progress_percentage >= 100) {
                $enrollment->status = 'completed';
            }
            $enrollment->save();
        }

        $nextModule = ($currentIndex !== false && $currentIndex < $totalModules - 1) ? $allModules->get($currentIndex + 1) : null;

        if ($nextModule) {
            return redirect()->route('modules.show', [$course->slug, $nextModule->slug])
                ->with('success', 'Module completed! Loaded next module: '.$nextModule->title);
        }

        return redirect()->route('courses.details', $course->slug)
            ->with('success', 'Congratulations! You have completed all modules for '.$course->title.'!');
    }

    private function resolveFileUrl(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }
        if (file_exists(public_path($path))) {
            return asset($path);
        }
        if (file_exists(public_path('storage/'.$path))) {
            return asset('storage/'.$path);
        }

        return asset($path);
    }
}
