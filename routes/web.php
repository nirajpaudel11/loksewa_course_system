<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminCurriculumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [FrontendController::class, 'dashboard']);
Route::get('/catalog', [FrontendController::class, 'catalog']);
Route::get('/analytics', [FrontendController::class, 'analytics']);
Route::get('/courses/{slug}', [FrontendController::class, 'courseDetails'])->name('courses.details');

Route::get('/visualizer', [FrontendController::class, 'visualizer'])->name('visualizer');

Route::middleware(['auth'])->group(function() {
    Route::get('/courses/{course_slug}/lessons/{lesson_slug}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/courses/{course_slug}/lessons/{lesson_slug}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course}/unenroll', [EnrollmentController::class, 'unenroll'])->name('courses.unenroll');

    Route::post('/admin/courses/{course}/modules', [AdminCurriculumController::class, 'addModule'])->name('admin.modules.add');
    Route::post('/admin/modules/{module}/chapters', [AdminCurriculumController::class, 'addChapter'])->name('admin.chapters.add');
    Route::post('/admin/chapters/{chapter}/lessons', [AdminCurriculumController::class, 'addLesson'])->name('admin.lessons.add');
});
