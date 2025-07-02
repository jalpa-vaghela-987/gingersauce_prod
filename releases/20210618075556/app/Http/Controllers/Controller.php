<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param User $user
     * @return Carbon
     */
    protected function minusCreditsGetExpired( User $user ){

        $credits_type = $user->minusCredits();
        $user->save();

        if ( $credits_type == User::CREDIT_TYPE_PACKAGE ){
            $expired_at = Carbon::now()->addMonths( $user->package->book_expiry );
        } else{
            $expired_at = Carbon::now()->addMonths( User::CREDIT_TYPE_LEFT_CREDITS_BOOK_DURATION );
        }
        return $expired_at;
    }
}
