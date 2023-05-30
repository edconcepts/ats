<?php

namespace App\Console;

use App\Jobs\SendEndInterviewEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:import location')->everyMinute();
        $schedule->command('app:import vacancy')->everyMinute();
        $schedule->command('app:import application')->everyMinute();
//        $schedule->job(new SendEndInterviewEmail)->everyFiveMinutes();
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
