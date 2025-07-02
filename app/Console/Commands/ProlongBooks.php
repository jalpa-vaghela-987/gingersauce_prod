<?php

namespace App\Console\Commands;

use App\BookExtends;
use App\BooksReccuringPayment;
use App\Brandbook;
use App\CreditLog;
use App\Invoice;
use App\Mail\BoughtSubscription;
use App\Mail\CheckoutInfo;
use App\Mail\CheckoutResult;
use App\Mail\FailedPaymentPackage;
use App\Package;
use App\Services\PaymentSystem\ICount;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProlongBooks extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:prolong';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prolongs book expiry date due to package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $expiry           = Carbon::now( 'Asia/Jerusalem' )->addDays(3)->setTime( 7, 0, 0 );
        $books_to_prolong = Brandbook::withTrashed()
            ->leftJoin( 'books_reccuring_payments', 'books_reccuring_payments.book_id', '=', 'brandbooks.id' )
            ->where( 'expires_at', '<', $expiry )
            ->whereNotNull('user_id')
            ->whereNotNull('book_id')
            ->where( 'status', 'public' )
            ->get();

        $ICount = new ICount();
        if ( $books_to_prolong->isNotEmpty() ) {
            foreach ( $books_to_prolong as $item ) {
                $user    = $item->user;
                $invoice = $this->createInvoice( $user, $item->book_id );
                if ( !empty( $invoice ) ) {
                    $ps_user = $ICount->loadUser( [ 'client_id' => $invoice->token->client_id ] );
                    if ( $ps_user[ 'status' ] ) {
                        $country = $ps_user[ 'client_info' ][ 'bus_country' ];
                        $vat     = $country == 'IL' ? 17 : 0;
                        $this->fillInvoiceAddress( $invoice, $ps_user[ 'client_info' ], $vat );

                        if ( config( 'app.env' ) !== 'local' ) {
                            Mail::to( 'mor.alon@gingersauce.co' )->send( new CheckoutInfo( $invoice ) );
                        }

                        info( 'Creating Bill' );
                        $bill_result = $this->createBill( $ICount, $invoice );
                        info( 'Result ', $bill_result );
                        if ( config( 'app.env' ) !== 'local' ) {
                            Mail::to( 'mor.alon@gingersauce.co' )->send( new CheckoutResult( $invoice, $bill_result ) );
                        }
                        if ( $bill_result[ 'status' ] === true ) { // bill created
                            try {
                                $doc = $this->createDoc( $ICount, $invoice, $bill_result, $ps_user[ 'client_info' ][ 'the_name' ] );
                            } catch ( \Exception $e ) {
                                info( $e->getMessage() );
                                info( $e->getTraceAsString() );
                            }

                            if ( $doc[ 'status' ] == true ) {
                                $invoice->file = $doc[ 'doc_url' ];
                                $invoice->save();
                            } else {
                                info( 'Failed on creating doc ' . var_export( $doc, true ) );
                            }

                            $invoice->status = 'paid';

                            $book = $invoice->book()->withTrashed()->first();
                            $book->expires_at = Carbon::now()->addYear();
                            $book->update();

                            $invoice->update();

                            CreditLog::create( [
                                'user_id'    => $invoice->user_id,
                                'invoice_id' => $invoice->id,
                                'type'       => 'book extend',
                                'comment'    => '',
                                'credits'    => $invoice->credits,
                            ] );
                        } else {
                            Mail::to( $user->email )->bcc( 'payments@gingersauce.co' )->send( ( new FailedPaymentPackage() ) );
                        }
                    }
                }
            }
        }
    }

    protected function createDoc( ICount $ICount, Invoice $invoice, $bill_result, $client_name ) {
        $total = $invoice->price + $invoice->price * ( $invoice->vat / 100 );

        $data = [
            'doctype'          => 'invrec',
            'custom_client_id' => $invoice->user_id,
            'client_name'      => $client_name,
            'email'            => $invoice->user->email,
            'vat_percent'      => $invoice->country == 'IL' ? 17 : 0,
            'paydate'          => date( 'Y-m-d' ),
            'currency_code'    => 'USD',
            'lang'             => 'en',
            'client_address'   => $invoice->country . ', ' . $invoice->city . ', ' . $invoice->state . ', ' . $invoice->address1 . ', ' . $invoice->address2,
            'items'            => [
                [
                    'description' => 'Gingersauce platform subscription ' . $invoice->description . ' package',
                    'unitprice'   => floatval( $invoice->price ),
                    'quantity'    => 1
                ]
            ],
            'cc'               => [
                "sum"               => floatval( $total ),
                "card_type"         => ( isset( $bill_result[ 'cc_card_type' ] ) ) ? $bill_result[ 'cc_card_type' ] : '',
                "card_number"       => ( isset( $bill_result[ 'cc_last4' ] ) ) ? $bill_result[ 'cc_last4' ] : '', // last 4 digits of credit-card number
                "exp_year"          => ( isset( $bill_result[ 'exp_year' ] ) ) ? $bill_result[ 'exp_year' ] : '',
                "exp_month"         => ( isset( $bill_result[ 'exp_month' ] ) ) ? $bill_result[ 'exp_month' ] : '',
                "holder_name"       => $invoice->token->name_on_card,
                "confirmation_code" => $bill_result[ 'confirmation_code' ],
            ],
            'doc_title'        => 'Ger-' . str_pad( $invoice->id, 6, '0', STR_PAD_LEFT ),
            'send_email'       => true,
            'email_to_client'  => true,
            'email_to'         => $invoice->user->email,
        ];

        return $ICount->createDOC( $data );
    }

    protected function createBill( ICount $ICount, Invoice $invoice ) {

        $total = $invoice->price + $invoice->price * ( $invoice->vat / 100 );
        $bill  = [
            'client_id'           => $invoice->token->client_id,
            'sum'                 => $total,
            'currency_code'       => 'USD',
            'payment_description' => 'Payment for gingersauce package ' . $invoice->description,
            'cc_token_id'         => $invoice->token->token_id,
            'is_test'             => config( 'app.env' ) !== 'production'
        ];

        info( 'Payment using token ' . $invoice->token->id );
        return $ICount->bill( $bill );
    }

    protected function fillInvoiceAddress( Invoice $invoice, $client_info, $vat ) {
        $invoice->name     = $client_info[ 'client_name' ];
        $invoice->country  = $client_info[ 'bus_country' ];
        $invoice->address1 = $client_info[ 'home_street' ];
        $invoice->address2 = $client_info[ 'home_no' ];
        $invoice->city     = $client_info[ 'home_city' ];
        $invoice->state    = $client_info[ 'bus_city' ];
        $invoice->zip      = $client_info[ 'home_zip' ];
        $invoice->vat      = $vat;
        $invoice->update();
    }

    protected function createInvoice( User $user, $book_id ) {
        $package = BookExtends::where( 'duration', 1 )->first();
        $token   = $user->paymentDefault()->first();

        if ( empty( $token ) ) {
            info( 'EMPTY TOKEN USER ID:' . $user->id );
            return null;
        }

        $invoice              = new Invoice();
        $invoice->book_id     = $book_id;
        $invoice->package_id  = $package->id;
        $invoice->price       = $package->price;
        $invoice->description = $package->duration . trans( 'profile.year' ) . ' @ $' . $package->price . ' USD';
        $invoice->type        = 'book';
        $invoice->user_id     = $user->id;
        $invoice->period      = $package->duration;
        $invoice->token_id    = $token->id;
        $invoice->save();
        return $invoice;
    }
}
