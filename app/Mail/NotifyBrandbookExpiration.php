<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyBrandbookExpiration extends Mailable
{
    use Queueable, SerializesModels;

    public $brandbook;
    public $term;
    public $past;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($brandbook, $term, $past = false)
    {
        $this->brandbook = $brandbook;
        $this->term = $term;
        $this->past = $past;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->brandbook->user->name.($this->past?', brandbook expired ':', brandbook expires in ').$this->term.($this->past?' ago':''))->markdown('mail.brandbook-expiration')->with(['term'=>$this->term, 'brandbook'=>$this->brandbook, 'past'=>$this->past]);
    }
}
