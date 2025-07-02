<?php


namespace App\Services\PaymentSystem;


class ICount{

    const API_URL = 'https://api.icount.co.il/api/v3.php/';

    const ACTIONS
        = [
            'login'                   => 'auth/login',
            'client_create_or_update' => 'client/create_or_update',
            'bill'                    => 'cc/bill',
            'card_store'              => 'cc_storage/store',
            'get_token_info'          => 'cc_storage/token_info',
            'create_doc'              => 'doc/create',
            'load_user'               => 'client/info',
            'recurring'               => 'hk/create',
            'recurring_pause'         => 'hk/pause',
            'recurring_resume'        => 'hk/resume',
            'recurring_info'          => 'hk/info'
        ];

    public $sid;

    public function __construct(){

        $data = [
            'user' => env( 'ICOUNT_USER' ),
            'pass' => env( 'ICOUNT_PASS' ),
            'cid'  => env( 'ICOUNT_CID' ),
        ];

        $auth_data = $this->request( self::ACTIONS[ 'login' ], $data );

        if ( $auth_data[ 'status' ] == true ){
            $this->sid = $auth_data[ 'sid' ];
            return $this;
        }

        info( 'Cant login to iCount ' . var_export( $auth_data, true ) );
        return null;
    }

    public function clientCreateOrUpdate( $data ){

        return $this->request( self::ACTIONS[ 'client_create_or_update' ], $data );
    }

    public function bill( $data ){

        return $this->request( self::ACTIONS[ 'bill' ], $data );
    }

    public function storeCard( $data ){

        return $this->request( self::ACTIONS[ 'card_store' ], $data );
    }

    public function getTokenInfo( $data ){

        return $this->request( self::ACTIONS[ 'get_token_info' ], $data );
    }

    public function createDOC( $data ){

        return $this->request( self::ACTIONS[ 'create_doc' ], $data );
    }

    public function loadUser( $data ){

        return $this->request( self::ACTIONS[ 'load_user' ], $data );
    }
    public function enableAutoRenewel($data){
        return $this->request( self::ACTIONS[ 'recurring' ], $data );
    }

    public function pauseAutoRenewel($data){
        return $this->request( self::ACTIONS[ 'recurring_pause' ], $data );
    }

    public function resumeAutoRenewel($data){
        return $this->request( self::ACTIONS[ 'recurring_resume' ], $data );
    }

    public function getRecurringInfo($data){
        return $this->request( self::ACTIONS[ 'recurring_info' ], $data );
    }


    protected function request( string $action, array $data ){

        if ( !empty( $this->sid ) ){
            $data[ 'sid' ] = $this->sid;
        }

        $endpoint = self::API_URL . $action;

        $ch = curl_init( $endpoint );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $data, null, '&' ) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $response = curl_exec( $ch );
        curl_close( $ch );
        return $this->decode( $response );
    }

    protected function decode( string $response ){

        return json_decode( $response, true );
    }

}
