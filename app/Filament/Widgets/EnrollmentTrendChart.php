<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class EnrollmentTrendChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = 'full';

    protected string $color = 'success';

    protected ?string $heading = 'Enrollment Trend';

    protected ?string $description = 'Daily new enrollments over the last 30 days';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $days = 30;
        $period = CarbonPeriod::create(
            Carbon::now()->subDays($days - 1)->startOfDay(),
            '1 day',
            Carbon::now()->endOfDay()
        );

        $counts = Enrollment::where('created_at', '>=', Carbon::now()->subDays($days))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $labels = [];
        $data = [];

        foreach ($period as $day) {
            $key = $day->format('Y-m-d');
            $labels[] = $day->format('M d');
            $data[] = $counts[$key] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Enrollments',
                    'data' => $data,
                    'fill' => 'start',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4,
                    'pointRadius' => 2,
                    'pointHoverRadius' => 5,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
