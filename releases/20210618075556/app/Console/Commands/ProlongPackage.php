<?php

namespace App\Console\Commands;

use App\CreditLog;
use App\FailedAttemptPayment;
use App\Invoice;
use App\Mail\CheckoutInfo;
use App\Mail\CheckoutResult;
use App\Mail\FailedPaymentPackage;
use App\Package;
use App\Services\PaymentSystem\ICount;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class ProlongPackage extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:prolong';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prolong package';

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
        $free_id             = optional(Package::where( 'alias', 'free' )->first())->id;
        $expiry              = Carbon::now( 'Asia/Jerusalem' )->addDay()->setTime( 7, 0, 0 );
        $packages_to_prolong = User::where( 'package_expires_at', '<', $expiry )
            ->where( 'package_id', '<>', $free_id )
            ->whereNotNull('user_id')
            ->leftJoin( 'package_reccuring_payments', 'package_reccuring_payments.user_id', '=', 'users.id' )->get();

        $this->prolong( $packages_to_prolong );

        $failed_attempts = FailedAttemptPayment::all();
        info('failed_attempts ' . $failed_attempts);
        $this->payOnFailed( $failed_attempts );
    }

    protected function payOnFailed( Collection $failed_attempts ) {
        if ( $failed_attempts->isNotEmpty() ) {
            $ICount = new ICount();
            foreach ( $failed_attempts as $failed_attempt ) {
                $user = User::find( $failed_attempt->user_id );
                if ( !empty( $user ) ) {

                    // very hot fix
                    $package = Package::find($user->package_id);
                    if(!$package) continue;

                    $invoice = $this->createInvoice( $user );
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

                                $user->failedAttempts()->delete();

                                CreditLog::create( [
                                    'user_id'    => $invoice->user_id,
                                    'invoice_id' => $invoice->id,
                                    'type'       => 'credit purchase',
                                    'comment'    => '',
                                    'credits'    => $invoice->credits,
                                ] );
                            } else {
                                Mail::to( $user->email )->bcc( 'payments@gingersauce.co' )->send( ( new FailedPaymentPackage() ) );
                                if ( $failed_attempt->attempts > 1 ) {
                                    $failed_attempt->delete();
                                    // remove autorenewal
                                    $user->packageReccuringPayments()->delete();

                                } else {
                                    $failed_attempt->attempts++;
                                    $failed_attempt->update();
                                }
                            }

                        } else {
                            info( "Unable load user ", $ps_user );
                        }
                    }
                }
            }
        }
    }

    protected function prolong( Collection $packages_to_prolong ) {
        if ( $packages_to_prolong->isNotEmpty() ) {

            $ICount = new ICount();
            foreach ( $packages_to_prolong as $item ) {
                $user = User::find( $item->user_id );

                // very hot fix
                $package = Package::find($user->package_id);
                if(!$package) continue;

                $invoice = $this->createInvoice( $user );
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

                            $user->failedAttempts()->delete();

                            CreditLog::create( [
                                'user_id'    => $invoice->user_id,
                                'invoice_id' => $invoice->id,
                                'type'       => 'credit purchase',
                                'comment'    => '',
                                'credits'    => $invoice->credits,
                            ] );


                            $user->package_credits    = $invoice->package->credits;
                            $user->package_id         = $invoice->package_id;
                            $user->package_expires_at = Carbon::now()->addDays( $invoice->period );
                            $user->update();

                        } else {
                            Mail::to( $user->email )->bcc( 'payments@gingersauce.co' )->send( ( new FailedPaymentPackage() ) );
                            $user->failedAttempts()->create( [
                                'attempts' => 1
                            ] );
                        }

                    } else {
                        info( "Unable load user ", $ps_user );
                    }
                }

            }
        }
    }


    protected function createDoc( ICount $ICount, Invoice $invoice, $bill_result, $client_name ) {
        $total = $invoice->price + $invoice->price * ( $invoice->vat / 100 );

        info(['doctype' => 'invrec']);
        info(['total' => $total]);

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

    protected function createInvoice( User $user ) {
        $token = $user->paymentDefault()->first();

        if ( empty( $token ) ) {
            info( 'EMPTY TOKEN USER ID:' . $user->id );
            return null;
        }

        $last_invoice = $user->invoices()->where( 'status', 'paid' )->whereNull( 'book_id' )->orderBy( 'created_at', 'desc' )->first();
        $annual       = false;
        if ( $last_invoice ) {
            $annual = $last_invoice->annual;
        }

        $invoice              = new Invoice();
        $invoice->package_id  = $user->package_id;
        $invoice->price       = $annual ? $user->package->annual_price : $user->package->price;
        $invoice->description = $user->package->getTranslatedAttribute( 'name' );
        $invoice->type        = 'package';
        $invoice->user_id     = $user->id;
        $invoice->period      = $annual ? Package::PACKAGE_YEAR_DURATION : Package::PACKAGE_MONTH_DURATION;
        $invoice->token_id    = $token->id;
        $invoice->save();
        return $invoice;
    }
}
