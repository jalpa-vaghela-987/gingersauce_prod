<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use NZTim\Mailchimp\Mailchimp;
use App\CreditLog;

class LogSuccessfulRegistration
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
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        CreditLog::create([
            'user_id'=>$event->user->id,
            'invoice_id'=>null,
            'type'=>'sign up',
            'comment'=>'',
            'credits'=>1,
        ]);
        try{
            $mc = new Mailchimp(config('services.mc.key'));
            $mc->subscribe(
                config('services.mc.list'), 
                $event->user->email, 
                $this->nameParams($event->user->name), 
                false
            );
        }catch(\Exception $e){
            report($e);
        }
    }

    private function nameParams($name)
    {
        $names = explode(" ", $name);
        $first_name = $names[0];
        unset($names[0]);
        $last_name = implode(' ', $names);

        $params = [
            'FNAME'=>$first_name,
            'LNAME'=>$last_name
        ];

        return $params;
    }
}
