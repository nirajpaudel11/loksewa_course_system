<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use Filament\Widgets\ChartWidget;

class CourseDifficultyChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = 1;

    protected string $color = 'warning';

    protected ?string $heading = 'Course Levels';

    protected ?string $description = 'Distribution by difficulty';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $beginner = Course::where('level', 'beginner')->count();
        $intermediate = Course::where('level', 'intermediate')->count();
        $advanced = Course::where('level', 'advanced')->count();

        return [
            'datasets' => [
                [
                    'data' => [$beginner, $intermediate, $advanced],
                    'backgroundColor' => [
                        'rgba(16, 185, 129, 0.85)',  // emerald for beginner
                        'rgba(245, 158, 11, 0.85)',  // amber for intermediate
                        'rgba(239, 68, 68, 0.85)',   // red for advanced
                    ],
                    'borderWidth' => 0,
                    'hoverOffset' => 8,
                ],
            ],
            'labels' => ['Beginner', 'Intermediate', 'Advanced'],
        ];
    }
}
