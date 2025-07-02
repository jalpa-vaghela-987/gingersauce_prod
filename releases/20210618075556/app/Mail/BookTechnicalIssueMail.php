<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookTechnicalIssueMail extends Mailable
{
    use Queueable, SerializesModels;

    private $brandbook;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($brandbook)
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
        return $this->view('mail.brandbook-technical-issue', ['brandbook' => $this->brandbook]);
    }
}
