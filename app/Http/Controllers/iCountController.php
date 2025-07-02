<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class iCountController extends Controller
{

    public $sid;

    public static function auth(){
        $ic = new self;
        $auth_data = $ic->request('https://api.icount.co.il/api/v3.php/auth/login', [
            'user'=>env('ICOUNT_USER'),
            'pass'=>env('ICOUNT_PASS'),
            'cid'=>env('ICOUNT_CID'),
        ], false);
        if($auth_data['status']==true){
            $ic->sid = $auth_data['sid'];
            return $ic;
        }
    }

    public function request(string $endpoint, array $data, bool $is_sid = true){
        if($is_sid)
            $data['sid']=$this->sid;
    	$ch = curl_init($endpoint);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, null, '&'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$response = curl_exec($ch);
    	curl_close($ch);
    	return $this->decode($response);
    }

    public function decode(string $response){
    	return json_decode($response, true);
    }
}
