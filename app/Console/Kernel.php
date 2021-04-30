<?php

namespace App\Console;

use App\Console\Commands\CrawlAdsCategoriesCommand;
use App\Console\Commands\CrawlAdsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Task to populate the categories and subcategories if theres something new
        $schedule->command(CrawlAdsCategoriesCommand::class)->daily();

        // Task to search for new ads in all categories
        $schedule->command(CrawlAdsCommand::class)->everyThirtyMinutes();

        // Run the queue
        $schedule->command('queue:work --stop-when-empty')->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
