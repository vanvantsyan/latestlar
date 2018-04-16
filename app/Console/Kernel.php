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
        Commands\ToursParser::class,
        Commands\SletatParser::class,
        Commands\CustomCommands::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Еженедельно обновляем данные туроператоров, так как они могут изменить направление
         $schedule->command('sletat parsOperators')->weekly();

        // Еженедельно обновляем информацию о количестве отелей определенной категории по странам и курортам
         $schedule->command('sletat parsHotelStars')->weekly();
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
