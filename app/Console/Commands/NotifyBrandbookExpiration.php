<?php

namespace App\Console\Commands;

use App\Jobs\BrandbookExpiration;
use Illuminate\Bus\Dispatcher;
use Illuminate\Console\Command;

class NotifyBrandbookExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify_brandbook:expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder to user on brandbook expiration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return app(Dispatcher::class)->dispatch(new BrandbookExpiration());
    }
}
