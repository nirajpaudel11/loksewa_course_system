<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PlatformStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $now = Carbon::now();

        // ── Total Users ──
        $totalUsers = User::count();
        $newUsersThisWeek = User::where('created_at', '>=', $now->copy()->subDays(7))->count();

        // Sparkline: daily user registrations over the last 14 days
        $userChart = $this->getDailyCountChart(User::class, 14);

        // ── Total Courses ──
        $totalCourses = Course::count();
        $publishedCourses = Course::where('is_published', true)->count();

        // ── Total Enrollments ──
        $totalEnrollments = Enrollment::count();
        $enrollmentsThisMonth = Enrollment::where('created_at', '>=', $now->copy()->subDays(30))->count();

        // Sparkline: daily enrollments over the last 14 days
        $enrollmentChart = $this->getDailyCountChart(Enrollment::class, 14);

        // ── Lesson Completion ──
        $totalProgress = LessonProgress::whereNotNull('completed_at')->count();
        $totalLessons = Lesson::count();
        $completionRate = $totalLessons > 0
            ? round(($totalProgress / ($totalLessons * max(1, User::whereHas('enrollments')->count()))) * 100, 1)
            : 0;

        // ── Reviews Due (Spaced Repetition) ──
        $reviewsDue = LessonProgress::whereNotNull('next_review_date')
            ->where('next_review_date', '<=', $now)
            ->count();

        // ── Active Enrollments ──
        $activeEnrollments = Enrollment::where('status', 'active')->count();
        $completedEnrollments = Enrollment::where('status', 'completed')->count();

        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description($newUsersThisWeek . ' new this week')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->descriptionColor($newUsersThisWeek > 0 ? 'success' : 'gray')
                ->chart($userChart)
                ->chartColor('primary')
                ->color('primary'),

            Stat::make('Courses', number_format($totalCourses))
                ->description($publishedCourses . ' published')
                ->descriptionIcon('heroicon-m-check-badge')
                ->descriptionColor('success')
                ->color('info'),

            Stat::make('Enrollments', number_format($totalEnrollments))
                ->description($enrollmentsThisMonth . ' this month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->descriptionColor($enrollmentsThisMonth > 0 ? 'success' : 'gray')
                ->chart($enrollmentChart)
                ->chartColor('success')
                ->color('success'),

            Stat::make('Lessons Completed', number_format($totalProgress))
                ->description($completionRate . '% avg completion')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->descriptionColor('info')
                ->color('warning'),

            Stat::make('Reviews Due', number_format($reviewsDue))
                ->description('Spaced repetition')
                ->descriptionIcon('heroicon-m-clock')
                ->descriptionColor($reviewsDue > 10 ? 'danger' : 'success')
                ->color($reviewsDue > 10 ? 'danger' : 'success'),

            Stat::make('Active / Completed', $activeEnrollments . ' / ' . $completedEnrollments)
                ->description('Enrollment status')
                ->descriptionIcon('heroicon-m-chart-pie')
                ->descriptionColor('primary')
                ->color('primary'),
        ];
    }

    /**
     * Build a sparkline array of daily counts for a given model over N days.
     */
    private function getDailyCountChart(string $model, int $days): array
    {
        $period = CarbonPeriod::create(
            Carbon::now()->subDays($days - 1)->startOfDay(),
            '1 day',
            Carbon::now()->endOfDay()
        );

        $counts = $model::where('created_at', '>=', Carbon::now()->subDays($days))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $chart = [];
        foreach ($period as $day) {
            $key = $day->format('Y-m-d');
            $chart[] = $counts[$key] ?? 0;
        }

        return $chart;
    }
}
