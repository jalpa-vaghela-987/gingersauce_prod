<?php

namespace App\Providers;

use App\Services\PaymentSystem\ICount;
use Illuminate\Support\ServiceProvider;

class PaymentSystemProvider extends ServiceProvider{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(){

        $this->app->singleton( ICount::class, function ( $app ){

            return new ICount();
        } );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(){
        //
    }
}
