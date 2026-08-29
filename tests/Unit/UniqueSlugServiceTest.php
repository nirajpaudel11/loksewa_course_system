<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Services\UniqueSlugService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniqueSlugServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_next_available_slug(): void
    {
        Course::create(['title' => 'Sample Course', 'slug' => 'sample-course']);
        Course::create(['title' => 'Sample Course', 'slug' => 'sample-course-2']);

        $slug = app(UniqueSlugService::class)->make(Course::class, 'Sample Course');

        $this->assertSame('sample-course-3', $slug);
    }
}
