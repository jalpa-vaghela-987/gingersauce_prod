<?php

namespace App\Http\Controllers;

use App\BookExtends;
use App\Brandbook;
use App\Invoice;
use App\Package;
use App\Services\PaymentSystem\ICount;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller {
    /**
     * Display a listing of the resource.
     *
     */
    public function index( ICount $ICount ) {

        $user = \Auth::user();

        $cards = $user->storedCards;

        $user_info = [];

        if ( $cards->isNotEmpty() ) {
            $payment_systetm_user_info = $ICount->loadUser( [ 'client_id' => $user->storedCards->first()->client_id ] );

            if ( $payment_systetm_user_info[ 'status' ] == true ) {
                $user_info = [
                    'address_1' => $payment_systetm_user_info[ 'client_info' ][ 'home_street' ],
                    'address_2' => $payment_systetm_user_info[ 'client_info' ][ 'home_city' ] . ' ' . $payment_systetm_user_info[ 'client_info' ][ 'home_zip' ],
                    'address_3' => $payment_systetm_user_info[ 'client_info' ][ 'bus_country' ] . ' ' . $payment_systetm_user_info[ 'client_info' ][ 'bus_city' ],
                    'card_name' => $payment_systetm_user_info[ 'client_info' ][ 'the_name' ]
                ];
            }
        }
        return view( 'profile.billing.index', [ 'cards' => $cards, 'user_info' => $user_info ] );


    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create() {

        return view( 'profile.billing.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store( Request $request, ICount $ICount ) {

        try {
            $exp = $request->exp_year . '-' . $request->exp_month;
            Carbon::createFromFormat( 'Y-m', $exp );
        } catch ( \Exception $e ) {
            return response()->json( [ 'msg' => trans( 'profile.bad_date_format' ) ], 400 );
        }

        try {


            $user   = \Auth::user();
            $stored = $user->storedCards()->first();

            $data = [
                'client_name' => $request->name,
                'bus_country' => $request->country,
                'home_street' => $request->address1,
                'home_no'     => $request->address2,
                'home_city'   => $request->city,
                'bus_city'    => $request->state,
                'home_zip'    => $request->zip,
                'email'       => $user->email,
                'mobile'      => $user->company_phone
            ];

            if ( $stored ) {

                $data[ 'client_id' ] = $stored->client_id;
                $response            = $ICount->clientCreateOrUpdate( $data );

            } else {

                $data[ 'custom_client_id' ] = config( 'app.env' ) . '_' . $user->id;
                $response                   = $ICount->clientCreateOrUpdate( $data );

            }

            if ( $response[ 'status' ] ) {
                $client_id = $client_id ?? $response[ 'client_id' ];

                $data = [
                    'client_id'      => $client_id,
                    'cc_number'      => $request->cc,
                    'cc_validity'    => $exp,
                    'cc_holder_name' => $request->name_on_card,
                ];

                if ( !empty( $request->id_on_card ) ) {
                    $data[ 'cc_holder_id' ] = $request->id_on_card;
                }

                $store = $ICount->storeCard( $data );

                if ( $store[ 'status' ] ) {

                    $data = [
                        'client_id'   => $client_id,
                        'cc_token_id' => $store[ 'cc_token_id' ]
                    ];

                    $token_info = $ICount->getTokenInfo( $data );

                    if ( $token_info[ 'status' ] ) {
                        $data = [
                            'client_id'        => $client_id,
                            'custom_client_id' => $store[ 'custom_client_id' ],
                            'buyer_card_mask'  => $token_info[ 'cc_last4' ],
                            'cc_card_type'     => $token_info[ 'cc_type' ],
                            'token_id'         => $token_info[ 'token_id' ],
                            'token'            => $token_info[ 'token' ],
                            'name_on_card'     => $token_info[ 'cc_holder_name' ]
                        ];

                        if ( !$user->paymentDefault()->first() ) {
                            $data[ 'default' ] = true;
                        }
                        $user->storedCards()
                            ->updateOrCreate(
                                [ 'token' => $store[ 'token' ] ],
                                $data
                            );
                        return response()->json( [], 200 );
                    }
                }
            } else {
                return response()->json( [ 'msg' => $response[ 'error_description' ] ] );
            }
        } catch ( \Exception $e ) {
            info( $e->getMessage() );
            info( $e->getTraceAsString() );
            info( var_export( $request->all(), true ) );
            if ( !empty( $response ) ) {
                info( var_export( $response, true ) );
            }
            if ( !empty( $store ) ) {
                info( var_export( $store, true ) );
            }
            if ( !empty( $token_info ) ) {
                info( var_export( $token_info, true ) );
            }

        }
        return response()->json( [], 500 );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit( $id ) {

        if ( \Auth::user()->id == $id ) {
            return view( 'profile.billing.edit' );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( $id ) {

        $card = \Auth::user()->storedCards()->where( 'id', $id )->where( 'default', 0 )->first();
        if ( $card ) {
            $card->delete();
            return response()->json( [], 200 );
        }
        return response()->json( [], 404 );
    }

    public function make_default( $id ) {

        $user = \Auth::user();
        $card = $user->storedCards()->where( 'id', $id )->first();
        if ( $card ) {
            $user->storedCards()->update( [
                'default' => 0
            ] );
            $card->default = 1;
            $card->update();
        } else {
            response()->json( [], 404 );
        }
    }

    public function update_billing_info( Request $request ) {

        $user      = \Auth::user();
        $client_id = $user->storedCards()->first()->client_id;
        if ( $client_id ) {
            $response = iCountController::auth()->request( 'https://api.icount.co.il/api/v3.php/client/create_or_update', [
                'client_id'   => $client_id,
                'client_name' => $request->name,
                'bus_country' => $request->country,
                'home_street' => $request->address1,
                'home_no'     => $request->address2,
                'home_city'   => $request->city,
                'bus_city'    => $request->state,
                'home_zip'    => $request->zip,
            ] );
            if ( $response[ 'status' ] ) {
                return response()->json( [], 200 );
            }

            info( 'Error updating client: USER ID - ' . $user->id . ' PAYMENT SYSTEM ID - ' . $client_id );
            info( var_export( $response, true ) );
        }

        return response()->json( [], 404 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleReccuring( Request $request ) {

        $response = [
            'errors'        => false,
            'error_message' => '',
            'message'       => 'ok'
        ];

        $user = \Auth::user();
        if ( 'on' == $request->action ) {
            $payment_methods = $user->storedCards->count();

            if ( !$payment_methods ) {
                return response()->json( [ 'errors' => true, 'error_message' => 'no_pm' ], 404 );
            }

            if ( 'book' == $request->type ) {
                /**
                 * @var $brandbook Brandbook
                 */
                $brandbook = $user->brandbooks()->where( 'id', $request->id )->first();
                if ( $brandbook ) {
                    $brandbook->bookReccuringPayment()->create();
                }

                return response()->json( $response, 200 );
            }

            if ( 'package' == $request->type ) {
                $user->packageReccuringPayments()->delete();
                $user->packageReccuringPayments()->create();
                return response()->json( $response, 200 );
            }
        }

        if ( 'off' == $request->action ) {
            if ( 'book' == $request->type ) {
                /**
                 * @var $brandbook Brandbook
                 */
                $brandbook = $user->brandbooks()->where( 'id', $request->id )->first();
                if ( $brandbook ) {
                    $brandbook->bookReccuringPayment()->delete();
                    return response()->json( $response, 200 );
                }
            }

            if ( 'package' == $request->type ) {
                $user->packageReccuringPayments()->delete();
                return response()->json( $response, 200 );
            }
        }

        $response[ 'error_message' ] = 'Opps!!!';
        $response[ 'errors' ]        = true;
        $response[ 'message' ]       = '';
        return response()->json( $response, 404 );
    }

    public function extendsGetJSON() {

        return BookExtends::all()->toJson();
    }

    public function packagesUpgrade() {

        $packages = Package::select( [ 'name', 'upper_title', 'credits', 'price', 'title', 'lower_title', 'color', 'id' ] )->whereIn( 'title', [ 'professional', 'agency' ] )->get();
        $user     = \Auth::user();
        $annual   = $user->invoices()->whereNull( 'book_id' )->where( 'status', 'paid' )->orderBy( 'created_at', "DESC" )->first()->annual;

        return response()->json( [ 'packages' => $packages, 'annual' => $annual ] );
    }
}
