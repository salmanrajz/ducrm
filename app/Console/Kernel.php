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

    protected $queues = [
        'notifications',
        'default',
    ];

    protected $commands = [
        //
        \App\Console\Commands\WhatsAppConsole::class,
        \App\Console\Commands\DailyHWTrackerCommand::class,
        \App\Console\Commands\DailyCount::class,

    ];

    protected function getQueueCommand()
    {
        // build the queue command
        $params = implode(' ', [
            '--daemon',
            '--tries=3',
            '--sleep=3',
            '--queue=' . implode(',', $this->queues),
        ]);

        return sprintf('queue:work %s', $params);
    }

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command($this->getQueueCommand())
            ->everyMinute()
            ->withoutOverlapping();
        $schedule->command('vocus_daily_count:update')->hourly();
        // $schedule->command('CoordinationFollow:name')->everyfi();
        $schedule->command('DailyHWTracker:send')->everyFiveMinutes('10:45');
        $schedule->command('BossUpdate:send')->dailyAt('20:00');
        // $schedule->command('CoordinationFollow:name')
        // ->everyMinute();
        // // ->between('20:00','21:00');
        $schedule->command('WhatsAppConsole')
        ->everyFifteenMinutes();
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
