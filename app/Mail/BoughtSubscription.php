<?php

namespace App\Mail;

use App\Invoice;
use App\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BoughtSubscription extends Mailable{
    use Queueable, SerializesModels;

    const SUBJECT_PROF_AND_AGENCY = 'You made a purchase, welcome aboard 🙌';
    const SUBJECT_BRAND_MANAGER   = 'You made a purchase, welcome aboard!';
    const SUBJECT_RECURRING       = 'Package — bought, professionalism — ensured! Yay 🥳';


    /**
     * @var Invoice $invoice
     */
    protected $invoice;

    protected $type;

    /**
     * Create a new message instance.
     *
     * @param Invoice $invoice
     * @param $type
     * @return void
     */
    public function __construct( Invoice $invoice, $type ){

        $this->invoice = $invoice;
        $this->type    = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){

        $markdown = $this->getMarkdown();
        $subject  = $this->getSubject();

        return $this->subject($subject)->view( $markdown )->with( [ 'invoice_link' => $this->invoice->file, 'subject' => $this->subject ] );
    }

    protected function getMarkdown(){
        return $this->type == Package::RECURRING ? 'mail.recurring_prof_and_agency' : 'mail.bought_prof_and_agency';
    }

    protected function getSubject(){

        if ( $this->type == Package::RECURRING ){
            return self::SUBJECT_RECURRING;
        }

        if ( $this->invoice->package->name == 'Brand Manager' ){
            return self::SUBJECT_BRAND_MANAGER;
        } else{
            return self::SUBJECT_PROF_AND_AGENCY;
        }
    }

}
