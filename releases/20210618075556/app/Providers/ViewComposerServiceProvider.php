<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {

        View::composer(['billing.choose_plan','billing.buy_plan'],function($view){

            $packages = \App\Package::where('language', config('app.locale'))
            ->free(false)
            ->orderBy('position', 'asc')
            ->take(3)
            ->get();
        
            $view->with('packages', $packages);
        });
    }
}
