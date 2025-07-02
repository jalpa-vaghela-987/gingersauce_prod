<?php

namespace App\Mail;

use App\Brandbook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookDeleteReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $brandbook;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( Brandbook $brandbook )
    {
        $this->brandbook = $brandbook;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject( $this->brandbook->user->name . ' Your brandbook will disappear after this date if you didn\'t extended the date' )
                    ->markdown( 'mail.book-delete-reminder' )
                    ->with( [ 'brandbook' => $this->brandbook ] );;
    }
}
