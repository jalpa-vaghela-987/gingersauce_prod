<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('draftize', function(){
	foreach(App\Brandbook::all() as $brandbook){
		$brandbook->status = 'draft';
		$brandbook->expires_at = Carbon\Carbon::now()->addDays(14);
		$brandbook->save();
	}
});

Artisan::command('packagize', function(){
	foreach(App\User::all() as $user){
		$user->package_name = 'manager';
		$user->package_expires_at = Carbon\Carbon::now()->addDays(365);
		$user->save();
	}
});