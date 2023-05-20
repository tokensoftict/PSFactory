<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('open:stock')->dailyAt('06:00')->appendOutputTo('storage/app/stockopening.txt');

        $schedule->command('open:material')->dailyAt('06:30')->appendOutputTo('storage/app/materialopening.txt');

        $schedule->command('neartoutof:product')->dailyAt('7:30')->appendOutputTo('storage/app/stockopening.txt');

        $schedule->command('neartoutof:material')->dailyAt('8:30')->appendOutputTo('storage/app/stockopening.txt');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
