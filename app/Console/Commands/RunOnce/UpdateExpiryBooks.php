<?php

namespace App\Console\Commands\RunOnce;

use App\Brandbook;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateExpiryBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bb:expirybb:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $expiry_at = Carbon::now()->addYear();
        Brandbook::whereNull('expires_at')->where('status', 'draft')->update( [
                                        'expires_at' => $expiry_at,
                                        'status'     => 'public'
                                    ] );
    }
}
