<?php

namespace App\Console\Commands;

use App\Brandbook;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateVersionColumn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bb_version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update bb_description column 1 and 2';

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
        $v1Ids  =   [];
        $v2Ids  =   [];
        Brandbook::chunk(100,function($records) use (&$v1Ids, &$v2Ids){
            foreach ($records as $record) {
                if($record->bb_version != 3){
                    if($record->tabCount() > 0) {
                        $record->bb_version = 2;
                        $v1Ids[] = $record->id;
                    } else {
                        $record->bb_version = 1;
                        $v2Ids[] = $record->id;
                    }
                }
                $record->save();
            }
        });
        $this->info("command excuted!");
        Log::info("v1 IDs:".json_encode($v1Ids));
        Log::info("v2 IDs:".json_encode($v2Ids));
    }
}
