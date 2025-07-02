<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Auth;

class CouponController extends Controller {

    public function check( Request $request ) {

        if ( Auth::check() ) {
            $coupon = Coupon::where( 'coupon', $request->coupon )->where( 'limit', '>', 0 )->firstOrFail();
            return response()->json( [ 'status' => 'ok', 'discount' => $coupon->discount, 'id' => $coupon->id ] );
        }

    }
}
