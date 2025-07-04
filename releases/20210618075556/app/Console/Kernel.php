<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\BillingWalker;

class Kernel extends ConsoleKernel {
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands
        = [
            //
        ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule( Schedule $schedule ) {

        $schedule->command( 'expired_books:delete' )->everyFiveMinutes();
        $schedule->command( 'expired_books:force_delete' )->everyFiveMinutes();
        $schedule->command( 'books:makedraft' )->timezone( 'Asia/Jerusalem' )->dailyAt( '6:59' );
        $schedule->command( 'books:prolong' )->timezone( 'Asia/Jerusalem' )->dailyAt( '7:00' );
        $schedule->command( 'package:prolong' )->timezone( 'Asia/Jerusalem' )->dailyAt( '7:00' );
        $schedule->command( 'package:expired' )->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {

        $this->load( __DIR__ . '/Commands' );

        require base_path( 'routes/console.php' );
    }
}
