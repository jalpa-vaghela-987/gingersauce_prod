<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function index( Request $request, $lang ) {

        if( in_array( $lang, config( 'app.locales' ) ) ) {

            App::setLocale( $lang );
            //$referer = url()->previous();

            $cookie = cookie( 'locale', $lang, 3600 * 24 * 30 );
            return redirect('/my')->withCookie( $cookie );
        } else {
            abort( 404 );
        }
    }
}
