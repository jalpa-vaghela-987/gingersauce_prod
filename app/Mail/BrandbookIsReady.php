<?php

namespace App\Mail;

use App\Brandbook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BrandbookIsReady extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $brandbook;

    public $subject;

    public function __construct(Brandbook $brandbook)
    {
        $this->brandbook = $brandbook;
        $this->subject = "Congrats! Your Brand Book \"{$brandbook->brand}\" is ready";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.brandbook-is-created', ['brandbook' => $this->brandbook]);
    }
}
