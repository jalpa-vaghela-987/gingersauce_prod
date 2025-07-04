<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle( Request $request, Closure $next ) {

        $cookie_locale = $request->cookie( 'locale' );
        $locale        = $cookie_locale ? $cookie_locale : config( 'app.locale' );
        App::setLocale( $locale );
        return $next( $request );
    }
}
