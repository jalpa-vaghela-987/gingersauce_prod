<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class MyPlansController extends Controller {
    public function index() {

        $user = \Auth::user();
        $plan = null;

        if ( $user->package ) {
            $plan = [
                'title'           => $user->package->title,
                'package_expiry'  => $user->package_expires_at,
                'books_remaining' => $user->credits() . '/' . $user->package->credits,
                'autorenewal'     => $user->packageReccuringPayments()->exists(),
                'id'              => $user->package_id
            ];
        }

        $books = $user->brandbooks()->public()->with( 'bookReccuringPayment' )->get();
        return view( 'profile.plans', [ 'plan' => $plan, 'books' => $books ] );
    }
}
