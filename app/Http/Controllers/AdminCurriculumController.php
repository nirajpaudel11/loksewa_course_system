<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Chapter;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCurriculumController extends Controller
{
    public function addModule(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        Module::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(100, 999),
            'order' => $request->order ?? (Module::where('course_id', $course->id)->count() + 1),
        ]);

        return redirect()->back()->with('success', 'Module added successfully.');
    }

    public function addChapter(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        Chapter::create([
            'module_id' => $module->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(100, 999),
            'order' => $request->order ?? (Chapter::where('module_id', $module->id)->count() + 1),
        ]);

        return redirect()->back()->with('success', 'Chapter added successfully.');
    }

    public function addLesson(Request $request, Chapter $chapter)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,video,pdf,quiz',
            'content' => 'nullable|string',
            'attachment_path' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $content = $request->content;
        if ($request->type === 'quiz' && empty($content)) {
            $content = json_encode([
                [
                    'question' => 'Sample GK Question: What is the capital of Nepal?',
                    'options' => ['Kathmandu', 'Pokhara', 'Lalitpur', 'Biratnagar'],
                    'answer' => 0,
                    'explanation' => 'Kathmandu is the capital and largest city of Nepal.'
                ]
            ]);
        }

        Lesson::create([
            'chapter_id' => $chapter->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(100, 999),
            'type' => $request->type,
            'content' => $content ?? 'Default lesson content goes here.',
            'attachment_path' => $request->attachment_path ?? ($request->type === 'pdf' ? 'storage/notes/Sample questions.pdf' : null),
            'order' => $request->order ?? (Lesson::where('chapter_id', $chapter->id)->count() + 1),
            'is_published' => true,
        ]);

        return redirect()->back()->with('success', 'Lesson added successfully.');
    }
}
