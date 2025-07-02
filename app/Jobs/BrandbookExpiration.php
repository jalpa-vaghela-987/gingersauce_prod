<?php

namespace App\Jobs;

use App\Brandbook;
use App\Mail\NotifyBrandbookExpiration;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BrandbookExpiration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 1 day before expiration of brandbook
        foreach(Brandbook::where('status', 'public')
                    ->cursor()->filter(function (Brandbook $brandBook) {
                return $brandBook->filterExpirationBrandBook($brandBook, 1);
            }) as $brandbook){
            Log::info(["1 day expiration called", $brandbook->brand." ".$brandbook->user->email]);
            Mail::to($brandbook->user->email)->queue(new NotifyBrandbookExpiration($brandbook, "1 day"));
        }

        // 10 days before expiration of brandbook
        foreach(Brandbook::where('status', 'public')
                    ->cursor()->filter(function (Brandbook $brandBook) {
                return $brandBook->filterExpirationBrandBook($brandBook, 10);
            }) as $brandbook){
            Log::info(["10 days expiration called".$brandbook->brand." ".$brandbook->user->email]);
            Mail::to($brandbook->user->email)->queue(new NotifyBrandbookExpiration($brandbook, "10 days"));
        }

        // 1 week later after expiration date
        foreach(Brandbook::where('status', 'public')
                    ->cursor()->filter(function (Brandbook $brandBook) {
                return $brandBook->filterExpirationBrandBook($brandBook, 8, true);
            }) as $brandbook){
            Log::info(["one week after".$brandbook->brand." ".$brandbook->user->email]);
            Mail::to($brandbook->user->email)->queue(new NotifyBrandbookExpiration($brandbook, Carbon::parse($brandbook->expires_at)->diffForHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE]), true));
        }
    }
}
