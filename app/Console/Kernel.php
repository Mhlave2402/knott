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
        // Cleanup expired quotes daily
        $schedule->command('quotes:cleanup-expired')
            ->daily()
            ->at('02:00');

        // Send reminder emails for pending quotes
        $schedule->command('quotes:send-reminders')
            ->dailyAt('09:00');

        // Generate AI matching analytics
        $schedule->command('analytics:ai-matching')
            ->weekly()
            ->sundays()
            ->at('03:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
