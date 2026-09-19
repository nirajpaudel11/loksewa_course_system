<?php

use App\Http\Controllers\AdminCurriculumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');
Route::post('/signup', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [FrontendController::class, 'landing'])->name('landing');
Route::get('/catalog', [FrontendController::class, 'catalog'])->name('courses.catalog');
Route::get('/courses/{slug}', [FrontendController::class, 'courseDetails'])->name('courses.details');

Route::get('/visualizer', [FrontendController::class, 'visualizer'])->name('visualizer');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [FrontendController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [FrontendController::class, 'analytics'])->name('analytics');
    Route::get('/courses/{course_slug}/modules/{module_slug}', [ModuleController::class, 'show'])->name('modules.show');
    Route::post('/courses/{course_slug}/modules/{module_slug}/complete', [ModuleController::class, 'complete'])->name('modules.complete');
    Route::get('/courses/{course_slug}/lessons/{lesson_slug}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/courses/{course_slug}/lessons/{lesson_slug}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course}/unenroll', [EnrollmentController::class, 'unenroll'])->name('courses.unenroll');

    // Spaced Repetition Flashcard Reviews (1 MCQ extracted per lesson)
    Route::get('/courses/{slug}/flashcards', [FrontendController::class, 'courseFlashcards'])->name('courses.flashcards');
    Route::get('/flashcards/due-reviews', [FrontendController::class, 'dueFlashcards'])->name('flashcards.due');
    Route::post('/lessons/{lesson}/rate-review', [FrontendController::class, 'rateLessonReview'])->name('lessons.rate-review');

    Route::post('/admin/courses/{course}/modules', [AdminCurriculumController::class, 'addModule'])->name('admin.modules.add');
    Route::post('/admin/modules/{module}/chapters', [AdminCurriculumController::class, 'addChapter'])->name('admin.chapters.add');
    Route::post('/admin/chapters/{chapter}/lessons', [AdminCurriculumController::class, 'addLesson'])->name('admin.lessons.add');
});
