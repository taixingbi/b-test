<?php

namespace App\Console;

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
        'App\Console\Commands\MarketingUsers',
        'App\Console\Commands\UpdateCalendar',

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('marketing:users')
//            ->everyFiveMinutes();
        ->daily();
//        ->hourly();
//        ->twiceDaily(1, 13);
//        $schedule->command('update:calendar')
//        ->everyMinute();

        //* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
        //sude nohup php artisan queue:work --daemon --tries=3
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
