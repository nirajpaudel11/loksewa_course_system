<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll(Course $course)
    {
        $userId = Auth::id();

        // Atomic check and create
        Enrollment::firstOrCreate(
            ['user_id' => $userId, 'course_id' => $course->id],
            ['status' => 'active', 'progress_percentage' => 0]
        );

        return redirect()->back()->with('success', 'You have successfully joined the '.$course->title.' preparation path!');
    }

    public function unenroll(Course $course)
    {
        $userId = Auth::id();

        if ($userId) {
            Enrollment::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->delete();
        }

        return redirect()->back()->with('success', 'You have been unenrolled from '.$course->title);
    }
}
