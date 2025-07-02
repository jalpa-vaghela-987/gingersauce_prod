<?php

namespace App\Http\Controllers;

use App\BookExtends;
use App\Brandbook;
use App\CcStoredUserCard;
use App\Http\Controllers\iCountController;
use App\Mail\BoughtSubscription;
use App\Mail\CheckoutInfo;
use App\Mail\CheckoutResult;
use App\Services\PaymentSystem\ICount;
use App\User;
use Illuminate\Http\Request;
use App\Events\InvoicePaid;
use App\Invoice;
use App\Package;
use App\Coupon;
use Auth;
use PDF;
use App\CreditLog;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;

use const http\Client\Curl\AUTH_ANY;

class InvoiceController extends Controller {

    public function index() {

        return view( 'invoice.index', [ 'invoices' => Auth::user()->invoices()->paid()->orderBy( 'created_at', 'desc' )->paginate( 10 ) ] );
    }

    public function create( Request $request ) {

        /**
         * @var $user User
         */
        $user    = Auth::user();
        $invoice = new Invoice;

        $annual = !empty( $request->type ) ? 1 : 0;
        $refund = 0;


        if ( 'book' == $request->invoice_type ) { // extending a book

            $book    = $user->brandbooks()->where( 'id', $request->book_id )->first();
            $package = BookExtends::findOrFail( $request->extend_id );
            if ( $book && $package ) {
                $book_id          = $book->id;
                $invoice->book_id = $book_id;
            } else {
                abort( 404 );
            }
            $description = $package->duration . trans( 'profile.year' ) . ' @ $' . $package->price . ' USD';
            if ( $package->save ) {
                $description .= ' ' . trans( 'profile.save' ) . ' ' . $package->save . '%';
            }

            $price  = $package->price;
            $period = $package->duration;

        } else if ( 'package' == $request->invoice_type ) { // from pricing, means common purchase

            $package     = Package::where( 'id', $request->package )->first();
            $description = $package->getTranslatedAttribute( 'title' );
            $price       = $annual ? $package->annual_price : $package->price;
            $period      = $this->getPeriod( $request->type, $package );

            if ( !empty( $request->watermark_book_id ) ) {
                $invoice->watermark_book_id = $request->watermark_book_id;
            }
        }

        //        $invoice->refund      = $refund;
        $invoice->type        = $request->invoice_type;
        $invoice->token_id    = $user->paymentDefault()->first() ? $user->paymentDefault()->first()->id : null;
        $invoice->description = $description;
        $invoice->package_id  = $package->id;
        $invoice->user_id     = $user->id;
        $invoice->price       = floatval( $price );
        if ( !empty( $request->book_id ) ) {
            $invoice->book_id = $request->book_id;
        }
        $invoice->period = $period;
        $invoice->annual = $annual;

        $invoice->save();

        return redirect()->route( 'invoice.single', $invoice );
    }

    public function single( Invoice $invoice ) {

        $user = Auth::user();
        if ( $invoice->user_id == $user->id ) {

            $order                      = [];
            $order[ 'extend_duration' ] = 0;

            if ( 'book' == $invoice->type ) { // extending a book

                $book    = $user->brandbooks()->where( 'id', $invoice->book_id )->first();
                $package = BookExtends::findOrFail( $invoice->package_id );

                $order[ 'name' ]            = trans( 'profile.extend_book' );
                $order[ 'upper_title' ]     = $book->brand;
                $order[ 'extend_duration' ] = $package->duration;
                $order[ 'credits' ]         = 0;

            } else if ( 'package' == $invoice->type ) { // from pricing, means common purchase

                $package                = $invoice->package;
                $order[ 'name' ]        = $package->getTranslatedAttribute( 'name' );
                $order[ 'upper_title' ] = $package->getTranslatedAttribute( 'lower_title' );
                $order[ 'credits' ]     = $package->credits;

            }


            $last_4    = null;
            $card_type = null;

            if ( $invoice->token_id ) {
                /**
                 * @var CcStoredUserCard $default_payment
                 */
                $default_payment = $user->storedCards()->where( 'id', $invoice->token_id )->first();

                if ( $default_payment ) {
                    $last_4    = substr( $default_payment->buyer_card_mask, -4 );
                    $card_type = strtolower( $default_payment->cc_card_type );
                } else {
                    $invoice->token_id = null;
                    $invoice->update();
                }
            }


            return view( 'invoice.single' )->with( [ 'invoice' => $invoice, 'last_4' => $last_4, 'card_type' => $card_type, 'order' => $order ] );
        }
    }

    protected function calculateRefund( $package_from ) {

        $user      = \Auth::user();
        $days_past = Carbon::createFromTimestamp( $user->credits_charge_date_ts )->diffInDays( Carbon::now() );
        $refund    = ( 365 - $days_past ) / 365 * $package_from->annual_price * 12;
        return round( $refund );
    }

    protected function getPrice( $type, Package $package ) {

        if ( $package->annual_price == $package->price || $package->annual_price == 0 ) {
            return $package->price;
        } else if ( intval( $type ) ) {
            return $package->annual_price * 12;
        } else {
            return $package->price;
        }
    }

    protected function isAnnual() {

    }

    protected function getPeriod( $type, Package $package ) {

        if ( $package->annual_price == $package->price || $package->annual_price == 0 ) {
            return Package::PACKAGE_YEAR_DURATION;
        } else if ( intval( $type ) ) {
            return Package::PACKAGE_YEAR_DURATION;
        } else {
            return Package::PACKAGE_MONTH_DURATION;
        }
    }

    public function pay( Invoice $invoice ) {

        event( new InvoicePaid( $invoice ) );
        return redirect()->route( 'brandbook.my' );
    }

    public function pdf( Invoice $invoice ) {

        $pdf = PDF::loadView( 'pdf.invoice', [ 'invoice' => $invoice ] );
        return $pdf->download( 'Ger-' . str_pad( $invoice->id, 6, '0', STR_PAD_LEFT ) . '.pdf' );
    }

    public function load_user( Request $request, ICount $ICount ) {


        $data = [
            'custom_client_id' => config( 'app.env' ) . '_' . $request->user_id
        ];

        $client_data = $ICount->loadUser( $data );

        if ( $client_data[ 'status' ] == true ) {
            return response()->json( [
                'status'    => 'ok',
                'name'      => $client_data[ 'client_info' ][ 'client_name' ],
                'country'   => $client_data[ 'client_info' ][ 'bus_country' ],
                'address1'  => $client_data[ 'client_info' ][ 'home_street' ],
                'address2'  => $client_data[ 'client_info' ][ 'home_no' ],
                'city'      => $client_data[ 'client_info' ][ 'home_city' ],
                'state'     => $client_data[ 'client_info' ][ 'bus_city' ],
                'zip'       => $client_data[ 'client_info' ][ 'home_zip' ],
                'client_id' => $client_data[ 'client_info' ][ 'client_id' ]
            ] );
        }

        return response()->json( [ 'status' => 'nok' ] );
    }


    public function thankyou( Invoice $invoice ) {

        return view( 'invoice.thankyou' )->with( [ 'invoice' => $invoice ] );
    }

    protected function getChargeCreditsAmount( Invoice $invoice ) {
        if ( !$invoice->package->prolong ) {
            if ( $invoice->annual ) {
                return 10;
            }
        }
        return $invoice->package->credits;
    }

    public function checkout( Invoice $invoice, Request $request, ICount $ICount ) {

        $user = Auth::user();
        if ( $request->using_token ) {
            $payment_default = $user->paymentDefault()->first();
            $client_info     = $ICount->loadUser( [ 'client_id' => $payment_default->client_id ] );
            if ( $client_info[ 'status' ] ) {
                $request->request->add( [ 'name' => $payment_default->name_on_card ] );
                $request->request->add( [ 'country' => $client_info[ 'client_info' ][ 'bus_country' ] ] );
                $request->request->add( [ 'address1' => $client_info[ 'client_info' ][ 'home_street' ] ] );
                $request->request->add( [ 'address2' => $client_info[ 'client_info' ][ 'home_no' ] ] );
                $request->request->add( [ 'city' => $client_info[ 'client_info' ][ 'home_city' ] ] );
                $request->request->add( [ 'state' => $client_info[ 'client_info' ][ 'home_zip' ] ] );
                $request->request->add( [ 'zip' => $client_info[ 'client_info' ][ 'bus_city' ] ] );
            } else {
                return redirect()->back()->withErrors( [ 'msg' => $client_info[ 'error_description' ] ] );
            }
        } else {
            $client_info = $this->createClient( $request, $ICount );
        }

        if ( $client_info[ 'status' ] ) {
            $client_id = $client_info[ 'client_id' ];
        } else {
            return back()->withErrors( [ 'msg' => $client_info[ 'error_description' ] ] );
        }


        $invoice->name     = $request->name;
        $invoice->country  = $request->country;
        $invoice->address1 = $request->address1;
        $invoice->address2 = $request->address2;
        $invoice->city     = $request->city;
        $invoice->state    = $request->state;
        $invoice->zip      = $request->zip;


        if ( $request->has( 'coupon_id' ) && !empty( $request->coupon_id ) ) {
            $coupon = Coupon::findOrFail( $request->coupon_id );
            $coupon->limit--;
            $coupon->used++;
            $coupon->save();
            $invoice->coupon_id = $coupon->id;
            $discount           = $invoice->price * ( $coupon->discount / 100 );
            $total              = ( $invoice->price - $discount );

        } else {
            $total = $invoice->price;
        }

        if ( !empty( $invoice->refund ) ) {
            $total = $total - $invoice->refund;
        }

        $total_for_bill = $total;

        $vat          = $request->vat ?? 0;
        $invoice->vat = $vat;
        $total        = $total + $total * ( $vat / 100 );

        $invoice->save();

        if ( config( 'app.env' ) !== 'local' ) {
            Mail::to( 'mor.alon@gingersauce.co' )->send( new CheckoutInfo( $invoice ) );
        }


        info( 'Creating Bill' );
        $bill_result = $this->createBill( $request, $ICount, $invoice->description, $total, $client_id );

        info( 'Result ', $bill_result );

        if ( config( 'app.env' ) !== 'local' ) {
            Mail::to( 'mor.alon@gingersauce.co' )->send( new CheckoutResult( $invoice, $bill_result ) );
        }

        if ( $bill_result[ 'status' ] === true ) { // bill created

            try {

                if ( !$request->using_token ) {
                    $this->storeCard( $request, $ICount, $client_id );
                }

                $doc = $this->createDoc( $request, $invoice, $ICount, $total, $bill_result );

                if ( $doc[ 'status' ] == true ) {
                    $invoice->file = $doc[ 'doc_url' ];
                    $invoice->save();
                } else {
                    info( 'Failed on creating doc ' . var_export( $doc, true ) );
                }

                $type            = null;
                $invoice->status = 'paid';

                /**
                 * check if user already had same package for the email template
                 */
                if ( $user->package_id == $invoice->package_id ) {
                    $type = Package::RECURRING;
                } else {
                    $type = Package::MONTHLY;
                }

                if ( config( 'app.env' ) !== "local" ) {
                    Mail::to( $user->email )->send( ( new BoughtSubscription( $invoice, $type ) ) );
                }
            } catch ( \Exception $e ) {
                info( "Error while creating documents" );
                info( $e->getMessage() );
                info( $e->getTraceAsString() );
            }

            $watermark_redirect = false;
            if ( $invoice->book_id ) { // Book prolong
                /**
                 * @var $book Brandbook
                 */
                $book             = $user->brandbooks()->where( 'id', $invoice->book_id )->first();
                $expiry           = $book->expires_at->addYears( $invoice->package->duration );
                $book->expires_at = $expiry;
                $book->update();

                // add book auterenewal
                $book->bookReccuringPayment()->create();
            } else { // Subscription
                $charge_credits = $this->getChargeCreditsAmount($invoice);
                if ( !empty( $invoice->watermark_book_id ) ) {
                    $watermark_redirect = true;
                    /**
                     * @var $book Brandbook
                     */
                    $book            = $user->brandbooks()->where( 'id', $invoice->watermark_book_id )->first();
                    $book->watermark = false;
                    $book->update();
                    
                    // add book auterenewal
                    $book->bookReccuringPayment()->create();

                    if ( $invoice->package->credits > 1 ) {
                        $charge_credits = $invoice->package->credits - 1;
                    }
                }
                if ( $charge_credits > 0 ) {
                    if ( $invoice->package->prolong ) {
                        $user->package_credits = $charge_credits;
                        $user->package_expires_at = Carbon::now()->addDays($invoice->period);
                        $user->credits_expire_date_at = now()->addMonths($invoice->package->credit_expiry);

                        // add autorenewal
                        $user->packageReccuringPayments()->create();

                    } else {
                        $user->left_credits += $charge_credits;
                    }
                    $user->package_id             = $invoice->package->id;
                    $user->update();
                }
            }
            $invoice->save();

            CreditLog::create( [
                'user_id'    => $user->id,
                'invoice_id' => $invoice->id,
                'type'       => 'credit purchase',
                'comment'    => '',
                'credits'    => $invoice->credits,
            ] );

            if ( $watermark_redirect ) {
                return redirect()->route( 'remove_after_payment', $invoice->watermark_book_id );
            } else {
                return redirect()->route( 'invoice.thankyou', $invoice );
            }


        } else {
            if ( !empty( $bill_result[ 'error_code' ] ) && 20004 == $bill_result[ 'error_code' ] ) {
                return redirect()->back()->withErrors( [ 'msg' => 'Your card was rejected by issuer, please try different card.' ] );
            }
            //return cc bill error
            return redirect()->back()->withErrors( [ 'msg' => $bill_result[ 'error_description' ] ] );
        }
    }

    protected function createBill( Request $request, ICount $ICount, $invoice_description, $total, $client_id ) {

        $bill = [
            'client_id'           => $client_id,
            'sum'                 => $total,
            'currency_code'       => 'USD',
            'payment_description' => 'Payment for gingersauce package ' . $invoice_description,
            'is_test'             => config( 'app.env' ) !== 'production'
        ];

        if ( $request->using_token ) {

            $token = Auth::user()->paymentDefault()->first();
            info( 'Payment using token ' . $token->id );

            if ( $token ) {
                $bill[ 'cc_token_id' ] = $token->token_id;
            }
        } else {

            $bill += [
                'cc_number'      => $request->cc,
                'cc_cvv'         => $request->cvc,
                'cc_validity'    => $request->exp_year . '-' . $request->exp_month,
                'cc_holder_name' => $request->name_on_card,
                'cc_holder_id'   => $request->id_on_card,
            ];
        }


        return $ICount->bill( $bill );
    }

    protected function createClient( Request $request, ICount $ICount ) {

        $user = Auth::user();

        $client = [
            'custom_client_id' => config( 'app.env' ) . '_' . $user->id,
            'client_name'      => $request->name,
            'bus_country'      => $request->country,
            'home_street'      => $request->address1,
            'home_no'          => $request->address2,
            'home_city'        => $request->city,
            'bus_city'         => $request->state,
            'home_zip'         => $request->zip,
            'email'            => $user->email,
            'mobile'           => $user->company_phone
        ];
        return $ICount->clientCreateOrUpdate( $client );

    }

    protected function createDoc( Request $request, Invoice $invoice, ICount $ICount, $total, $result ) {

        $user = Auth::user();

        $description = '';
        if ( $invoice->book_id ) {
            $description = $invoice->description;
        } else {
            $description = 'Gingersauce platform ' . $invoice->description . ' Package ' . $invoice->package->credits . ' Books';
        }

        $items = [
            [
                'description' => $description,
                'unitprice'   => $total,
                'quantity'    => 1,
            ]
        ];

        if ( $invoice->refund > 0 ) {
            $refund_item = [
                'description' => 'Refund for package Professional',
                'unitprice'   => -$invoice->refund,
                'quantity'    => 1,
            ];
            $items[]     = $refund_item;
        }

        $data = [
            'doctype'          => 'invoice',
            'custom_client_id' => $user->id,
            'client_name'      => $request->name,
            'email'            => $user->email,
            'vat_percent'      => $invoice->country == 'IL' ? 17 : 0,
            'paydate'          => date( 'Y-m-d' ),
            'currency_code'    => 'USD',
            'lang'             => 'en',
            'client_address'   => $request->country . ', ' . $request->city . ', ' . $request->state . ', ' . $request->address1 . ', ' . $request->address2,
            'items'            => $items,
            'cc'               => [
                "sum"               => floatval( $total ),
                "card_type"         => ( isset( $result[ 'cc_card_type' ] ) ) ? $result[ 'cc_card_type' ] : '',
                "card_number"       => ( isset( $result[ 'cc_last4' ] ) ) ? $result[ 'cc_last4' ] : '', // last 4 digits of credit-card number
                "exp_year"          => ( isset( $result[ 'exp_year' ] ) ) ? $result[ 'exp_year' ] : '',
                "exp_month"         => ( isset( $result[ 'exp_month' ] ) ) ? $result[ 'exp_month' ] : '',
                "holder_id"         => $request->id_on_card,
                "holder_name"       => $request->name_on_card,
                "confirmation_code" => $result[ 'confirmation_code' ],
            ],
            'doc_title'        => 'Ger-' . str_pad( $invoice->id, 6, '0', STR_PAD_LEFT ),
            'send_email'       => true,
            'email_to_client'  => true,
            'email_to'         => $user->email,
        ];

        return $ICount->createDOC( $data );
    }

    protected function storeCard( Request $request, ICount $ICount, $client_id ) {

        $card_data = [
            'client_id'      => $client_id,
            'cc_number'      => $request->cc,
            'cc_validity'    => $request->exp_year . '-' . $request->exp_month,
            'cc_holder_name' => $request->name_on_card,
            'cc_holder_id'   => $request->id_on_card,
        ];

        info( 'storing card' );
        $stored = $ICount->storeCard( $card_data );
        info( 'result', $stored );


        $token_request = [
            'client_id'   => $client_id,
            'cc_token_id' => $stored[ 'cc_token_id' ]
        ];

        $token_info = $ICount->getTokenInfo( $token_request );

        if ( $token_info[ 'status' ] ) {

            $cc_stored_user_card
                = [
                'client_id'        => $client_id,
                'custom_client_id' => $stored[ 'custom_client_id' ],
                'buyer_card_mask'  => $token_info[ 'cc_last4' ],
                'cc_card_type'     => $token_info[ 'cc_type' ],
                'token_id'         => $token_info[ 'token_id' ],
                'token'            => $token_info[ 'token' ],
                'name_on_card'     => $token_info[ 'cc_holder_name' ]
            ];

            $user = Auth::user();

            $default = $user->storedCards()->where( 'default', 1 )->count();
            if ( !$default ) {
                $cc_stored_user_card[ 'default' ] = 1;
            }

            $user->storedCards()
                ->updateOrCreate(
                    [ 'token' => $stored[ 'token' ] ],
                    $cc_stored_user_card
                );
        }
    }
}
