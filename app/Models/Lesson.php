<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'quiz_questions' => 'array',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Lesson $lesson) {
            if (empty($lesson->module_id) && ! empty($lesson->chapter_id)) {
                $chapter = Chapter::find($lesson->chapter_id);
                if ($chapter && $chapter->module_id) {
                    $lesson->module_id = $chapter->module_id;
                }
            }
        });
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function getCourseAttribute()
    {
        return $this->module?->course ?? $this->chapter?->module?->course;
    }
}
