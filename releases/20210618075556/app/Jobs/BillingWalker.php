<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\User;
use Mail;
use App\Mail\NotifyBrandbookExpiration;

class BillingWalker implements ShouldQueue
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
        if(Carbon::now()->format('d')==1){
            // today is first of month, add credits to users
            foreach(User::all() as $user){
                if(strtotime($user->package_expires_at)-time()>60*60*24){
                    if($user->package_name=='professional')
                        $user->left_credits = 5;
                    if($user->package_name=='agency')
                        $user->left_credits = 30;
                    $user->save();
                }else{
                    $user->left_credits = 0;
                    $user->save();
                }
            }

            // automate emails about expiration of brandbooks
            // if not draft – 2 weeks
            foreach(Brandbook::where('status', 'public')->where('expires_at', '>', Carbon::now()->addDays(14))->get() as $brandbook){
                Mail::to($brandbook->user->email)->queue(new NotifyBrandbookExpiration($brandbook, Carbon::parse($brandbook->expires_at)->diffForHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE])));
            }
            // 1 week
            foreach(Brandbook::where('status', 'public')->where('expires_at', '>', Carbon::now()->addDays(7))->get() as $brandbook){
                Mail::to($brandbook->user->email)->queue(new NotifyBrandbookExpiration($brandbook, Carbon::parse($brandbook->expires_at)->diffForHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE])));
            }
            // 1 day
            foreach(Brandbook::where('status', 'public')->where('expires_at', '>', Carbon::now()->addDays(1))->get() as $brandbook){
                Mail::to($brandbook->user->email)->queue(new NotifyBrandbookExpiration($brandbook, Carbon::parse($brandbook->expires_at)->diffForHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE])));
            }
            // change status of brandbook
            foreach(Brandbook::where('status', 'public')->where('expires_at', '>', Carbon::now())->get() as $brandbook){
                $brandbook->status = 'trashed';
                $brandbook->save();
            }
            // 1 week after
            foreach(Brandbook::where('status', 'public')->where('expires_at', '<', Carbon::now()->addDays(7))->get() as $brandbook){
                Mail::to($brandbook->user->email)->queue(new NotifyBrandbookExpiration($brandbook, Carbon::parse($brandbook->expires_at)->diffForHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE]), true));
            }
            // 2 weeks after
            foreach(Brandbook::where('status', 'public')->where('expires_at', '<', Carbon::now()->addDays(14))->get() as $brandbook){
                Mail::to($brandbook->user->email)->queue(new NotifyBrandbookExpiration($brandbook, Carbon::parse($brandbook->expires_at)->diffForHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE]), true));
            }
            //delete
            foreach(Brandbook::where('status', 'public')->where('expires_at', '<', Carbon::now()->addDays(15))->get() as $brandbook){
                $brandbook->delete();
            }
        }
    }
}
