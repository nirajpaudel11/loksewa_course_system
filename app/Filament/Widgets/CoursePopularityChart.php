<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use Filament\Widgets\ChartWidget;

class CoursePopularityChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = 1;

    protected string $color = 'info';

    protected ?string $heading = 'Most Popular Courses';

    protected ?string $description = 'By total enrollments';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $courses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->limit(8)
            ->get();

        $labels = $courses->map(function ($course) {
            // Truncate long titles for chart readability
            return strlen($course->title) > 22
                ? substr($course->title, 0, 20).'…'
                : $course->title;
        })->toArray();

        $data = $courses->pluck('enrollments_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Enrollments',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(16, 185, 129, 0.8)',   // emerald
                        'rgba(59, 130, 246, 0.8)',   // blue
                        'rgba(245, 158, 11, 0.8)',   // amber
                        'rgba(239, 68, 68, 0.8)',    // red
                        'rgba(139, 92, 246, 0.8)',   // purple
                        'rgba(236, 72, 153, 0.8)',   // pink
                        'rgba(20, 184, 166, 0.8)',   // teal
                        'rgba(249, 115, 22, 0.8)',   // orange
                    ],
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
