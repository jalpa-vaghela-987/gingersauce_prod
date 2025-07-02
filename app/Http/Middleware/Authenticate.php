<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request,$vue_capture=null)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $seg1 = $request->segment(1);
        $seg2 = $request->segment(2);
        $seg3 = (int) $request->segment(3);
        $is_preview_new = ($seg1 == "my" && $seg2 == "view-new" && is_numeric($seg3));

        // Bypass authentication for the specific condition
        if ($is_preview_new) {
            return $next($request);
        }
        $this->authenticate($request, $guards);
        return $next($request);
    }
}
