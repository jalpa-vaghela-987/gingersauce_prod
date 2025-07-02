<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Share;
use App\Brandbook;
use Auth;
use App\User;
use App\Referrers;
use App\CreditLog;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = Auth::user();
        $user->last_login = new \DateTime;
        $user->save();
        if(session()->has('bb.shared.id')){
            Share::create([
                'owner_id'=>Brandbook::findOrFail(session('bb.shared.id'))->user_id,
                'user_id'=>Auth::id(),
                'brandbook_id'=>session('bb.shared.id'),
                'action'=>'view',
            ]);
        }
        if(session()->has('ginger.referrer')){
            $ref = Referrers::findOrFail(session('ginger.referrer'));
            $ref->is_used = true;
            $ref->save();

            $us = User::findOrFail($ref->user_id);
            $us->left_credits++;
            $us->save();

            CreditLog::create([
                'user_id'=>$us->id,
                'invoice_id'=>null,
                'type'=>'referal',
                'comment'=>'',
                'credits'=>1,
            ]);
        }
    }
}
