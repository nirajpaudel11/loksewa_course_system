<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Services\UniqueSlugService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminCurriculumController extends Controller
{
    public function __construct(
        protected UniqueSlugService $uniqueSlugService
    ) {}

    public function addModule(Request $request, Course $course)
    {
        $this->authorizeAdmin($request);

        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        Module::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'slug' => $this->uniqueSlugService->make(Module::class, $request->title),
            'order' => $request->order ?? (Module::where('course_id', $course->id)->count() + 1),
        ]);

        return redirect()->back()->with('success', 'Module added successfully.');
    }

    public function addChapter(Request $request, Module $module)
    {
        $this->authorizeAdmin($request);

        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        Chapter::create([
            'module_id' => $module->id,
            'title' => $request->title,
            'slug' => $this->uniqueSlugService->make(Chapter::class, $request->title),
            'order' => $request->order ?? (Chapter::where('module_id', $module->id)->count() + 1),
        ]);

        return redirect()->back()->with('success', 'Chapter added successfully.');
    }

    public function addLesson(Request $request, Chapter $chapter)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,video,pdf,quiz',
            'content' => 'nullable|string',
            'attachment_path' => 'nullable|string|max:2048',
            'order' => 'nullable|integer|min:0',
        ]);

        $attachmentPath = $validated['attachment_path'] ?? null;
        if (in_array($validated['type'], ['video', 'pdf'], true)) {
            $attachmentPath = $attachmentPath ?: ($validated['content'] ?? null);
        }

        if (in_array($validated['type'], ['text', 'quiz'], true) && blank($validated['content'] ?? null)) {
            throw ValidationException::withMessages(['content' => 'Content is required for text and quiz lessons.']);
        }

        if (in_array($validated['type'], ['video', 'pdf'], true) && blank($attachmentPath)) {
            throw ValidationException::withMessages(['attachment_path' => 'An attachment path is required for video and PDF lessons.']);
        }

        if ($validated['type'] === 'quiz') {
            json_decode($validated['content'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw ValidationException::withMessages(['content' => 'Quiz content must be valid JSON.']);
            }
        }

        Lesson::create([
            'chapter_id' => $chapter->id,
            'title' => $validated['title'],
            'slug' => $this->uniqueSlugService->make(Lesson::class, $validated['title']),
            'type' => $validated['type'],
            'content' => in_array($validated['type'], ['text', 'quiz'], true) ? $validated['content'] : null,
            'attachment_path' => $attachmentPath,
            'order' => $validated['order'] ?? (Lesson::where('chapter_id', $chapter->id)->count() + 1),
            'is_published' => true,
        ]);

        return redirect()->back()->with('success', 'Lesson added successfully.');
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()?->hasRole('admin'), 403);
    }
}
