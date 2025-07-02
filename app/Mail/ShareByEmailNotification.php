<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Brandbook;
use App\User;

class ShareByEmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $brandbook;
    public $sender;
    public $link;

    public function __construct(User $sender, Brandbook $brandbook, string $link)
    {
        $this->brandbook = $brandbook;
        $this->sender = $sender;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->sender->name.' has shared a '.$this->brandbook->brand.' brandbook')->markdown('mail.share-email-notification', ['brandbook'=>$this->brandbook, 'sender'=>$this->sender, 'link'=>$this->link]);
    }
}
