<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TrendingService;

class UpdateTrendingScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:update-trending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the trending scores for all courses using the time-decay algorithm.';

    /**
     * Execute the console command.
     */
    public function handle(TrendingService $trendingService)
    {
        $this->info('Calculating trending scores...');
        
        $trendingService->calculateTrendingScores();
        
        $this->info('Trending scores updated successfully!');
    }
}
