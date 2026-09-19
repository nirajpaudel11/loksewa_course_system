<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function chapters(): HasManyThrough
    {
        return $this->hasManyThrough(Chapter::class, Module::class);
    }

    public function lessons()
    {
        return Lesson::where(function ($query) {
            $query->whereHas('module', function ($q) {
                $q->where('course_id', $this->id);
            })->orWhereHas('chapter.module', function ($q) {
                $q->where('course_id', $this->id);
            });
        });
    }

    public function getLessonsAttribute()
    {
        return $this->lessons()->orderBy('order')->get();
    }

    public function prerequisites(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_prerequisites', 'course_id', 'prerequisite_course_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
