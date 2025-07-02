<?php

namespace App\Listeners;

use App\Events\InvoicePaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignCreditsToUser
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
     * @param  InvoicePaid  $event
     * @return void
     */
    public function handle(InvoicePaid $event)
    {
        $user = $event->invoice->user;
        $user->left_credits += $event->invoice->credits;
        $user->package_id = $event->invoice->package_id;
        $user->save();
    }
}
