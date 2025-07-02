<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class ReferAFriend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $sender;
    public $link;
    public function __construct(User $sender, string $link)
    {
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
        return $this->subject($this->sender->name.' invites you to use Gingersauce')->markdown('mail.refer-a-friend')->with(['sender'=>$this->sender, 'link'=>$this->link]);
    }
}
