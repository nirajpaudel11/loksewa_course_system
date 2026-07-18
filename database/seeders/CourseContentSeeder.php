<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Module;
use App\Models\Chapter;
use App\Models\Lesson;
use Illuminate\Support\Str;

class CourseContentSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Advanced PHP Mastery',
                'description' => 'Deep dive into PHP internals, algorithms, and design patterns.',
                'level' => 'advanced',
                'thumbnail' => 'https://images.unsplash.com/photo-1599507593499-a3f7f7d9a2cc?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'title' => 'Laravel for Beginners',
                'description' => 'Learn the world\'s most popular PHP framework from scratch.',
                'level' => 'beginner',
                'thumbnail' => 'https://images.unsplash.com/photo-1537432376769-00f5c2f4c8d2?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'title' => 'Modern Web Design with CSS',
                'description' => 'Master Flexbox, Grid, and beautiful responsive layouts.',
                'level' => 'intermediate',
                'thumbnail' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'title' => 'Database Architecture & SQL',
                'description' => 'How to design scalable databases for high-performance applications.',
                'level' => 'advanced',
                'thumbnail' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?q=80&w=600&auto=format&fit=crop'
            ]
        ];

        foreach ($courses as $c) {
            $course = Course::create([
                'title' => $c['title'],
                'slug' => Str::slug($c['title']),
                'description' => $c['description'],
                'level' => $c['level'],
                'thumbnail' => $c['thumbnail'],
                'is_published' => true,
            ]);

            $moduleTitle = 'Getting Started with ' . $course->title;
            // Add a module
            $module = Module::create([
                'course_id' => $course->id,
                'title' => $moduleTitle,
                'slug' => Str::slug($moduleTitle),
                'order' => 1,
            ]);

            $chapterTitle = 'Foundations of ' . $course->title;
            // Add a chapter
            $chapter = Chapter::create([
                'module_id' => $module->id,
                'title' => $chapterTitle,
                'slug' => Str::slug($chapterTitle),
                'order' => 1,
            ]);

            // Add lessons
            Lesson::create([
                'chapter_id' => $chapter->id,
                'title' => 'Introduction to ' . $course->title,
                'slug' => Str::slug('Introduction to ' . $course->title),
                'type' => 'video',
                'content' => 'Watch this video to get started with ' . $course->title,
                'order' => 1,
                'is_published' => true,
            ]);
        }
    }
}
