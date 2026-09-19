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

        // Create or update enrollment with 'pending' status awaiting admin verification
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if ($enrollment) {
            if ($enrollment->status === 'rejected') {
                $enrollment->update(['status' => 'pending']);

                return redirect()->back()->with('info', 'Your enrollment request for '.$course->title.' has been re-submitted for admin verification.');
            }

            return redirect()->back()->with('info', 'You already have an enrollment record for this course.');
        }

        Enrollment::create([
            'user_id' => $userId,
            'course_id' => $course->id,
            'status' => 'pending',
            'progress_percentage' => 0,
        ]);

        return redirect()->back()->with('success', 'Enrollment submitted! An administrator will verify your request before you can access the lesson materials.');
    }

    public function unenroll(Course $course)
    {
        $userId = Auth::id();

        if ($userId) {
            $enrollment = Enrollment::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->first();

            if ($enrollment) {
                if ($enrollment->status === 'completed' || $enrollment->progress_percentage >= 100) {
                    return redirect()->back()->with('error', 'Unenrollment is disabled for completed courses.');
                }

                $enrollment->delete();
            }
        }

        return redirect()->back()->with('success', 'You have been unenrolled from '.$course->title);
    }
}
