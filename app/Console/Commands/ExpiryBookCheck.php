<?php

namespace App\Console\Commands;

use App\Brandbook;
use Illuminate\Console\Command;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ExpiryBookCheck extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired_books:delete';
    protected $log;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expiry on books';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){

        parent::__construct();
//        $this->log = new Logger('expiry');
//        $this->log->pushHandler(new StreamHandler(storage_path('logs/expiry/expiry.log')), Logger::INFO);
//        $this->log->info('hello');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        Brandbook::where( 'expires_at', '<', now() )->delete();
    }
}
