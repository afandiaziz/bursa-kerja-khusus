<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run the command every two days at 8:00 AM
        // $schedule->command('app:auto-vacancy-alert')->cron('0 8 */2 * *');
        $schedule->command('app:auto-vacancy-alert')->dailyAt('08:00');
        // $schedule->command('app:auto-vacancy-preprocessing')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
