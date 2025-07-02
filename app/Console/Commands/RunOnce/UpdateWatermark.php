<?php

namespace App\Console\Commands\RunOnce;

use App\Brandbook;
use Illuminate\Console\Command;

class UpdateWatermark extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watermark:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update all brandbooks with watermark, official - false; darft - true';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        Brandbook::where( 'status', Brandbook::BOOK_STATUSES_DRAFT )->orWhere( 'status', Brandbook::BOOK_STATUSES_TRASH )->update( [
            'watermark' => true
        ] );
    }
}
