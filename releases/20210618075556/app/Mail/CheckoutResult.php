<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Invoice;

class CheckoutResult
    extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $invoice;

    public $api_response;

    public function __construct( Invoice $invoice, $api_response )
    {
        $this->invoice      = $invoice;
        $this->api_response = $api_response;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject( $this->invoice->user->name . ' checkout process result' )
                    ->markdown( 'mail.checkout-result' )
                    ->with( [ 'invoice' => $this->invoice, 'api_response' => $this->api_response ] );
    }
}
