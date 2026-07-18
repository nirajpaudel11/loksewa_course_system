<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function prerequisites()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisites', 'course_id', 'prerequisite_course_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get all lessons for the course through modules and chapters.
     */
    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,
            Chapter::class,
            'module_id', // This is wrong, it needs to go through Module
            'chapter_id',
            'id',
            'id'
        );
    }
}
