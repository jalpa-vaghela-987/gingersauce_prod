<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Brandbook;
use App\Share;
use App\Invoice;
use App\CreditLog;

class User extends \TCG\Voyager\Models\User {

    use Notifiable;

    const CREDIT_TYPE_LEFT_CREDITS = 'left_credits';
    const CREDIT_TYPE_PACKAGE      = 'package_credits';

    const CREDIT_TYPE_LEFT_CREDITS_BOOK_DURATION = 6; // months

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'name', 'email', 'password', 'provider', 'provider_id', 'avatar', 'avatar_original'
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
            'password', 'remember_token',
        ];

    protected $dates = [ 'last_login', 'package_expires_at' ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'email_verified_at' => 'datetime',
        ];

    public function can_create_new() {

        return true;
    }

    public function package() {

        return $this->hasOne( 'App\Package', 'id', 'package_id' );
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brandbooks() {

        return $this->hasMany( 'App\Brandbook' );
    }

    public function shares() {

        return $this->hasMany( 'App\Share', 'owner_id' );
    }

    public function credits() {

        return $this->left_credits + $this->package_credits;
    }

    public function invoices() {

        return $this->hasMany( Invoice::class, 'user_id', 'id' );
    }


    /**
     * @return string credit type
     */
    public function minusCredits() {

        if ( $this->package_credits > 0 ) {
            $this->package_credits--;
            return self::CREDIT_TYPE_PACKAGE;
        } else {
            $this->left_credits--;
            return self::CREDIT_TYPE_LEFT_CREDITS;
        }
    }

    public static function get_data_for_admin( $id ) {

        return [
            'amount_spent'  => Invoice::where( 'user_id', $id )->sum( 'price' ),
            'credits_used'  => Brandbook::where( 'user_id', $id )->count(),
            'credits_total' => CreditLog::where( 'user_id', $id )->sum( 'credits' ) + 1,
            'credits_ref'   => Referrers::where( 'user_id', $id )->where( 'is_used', true )->count(),
        ];
    }

    public function can_do( $action, Brandbook $brandbook ) {

        if ( $this->isAdmin() ) {
            return true;
        }

        if ( $brandbook->user_id == $this->id ) {

            if ( $brandbook->status == Brandbook::BOOK_STATUSES_PUBLIC ) {
                return true;
            }

            switch ( $action ) {
                case 'can_remove_wm' :
                    return $this->credits() > 0;
                case 'download':
                case 'view':
                case 'edit':
                case 'duplicate':
                case 'delete':
                    return true;
            }
        } else {
            $sh = Share::where( 'user_id', $this->id )->where( 'brandbook_id', $brandbook->id )->first();

            if(!$sh) return false;

            if ( $sh->action == $action ) {
                return true;
            }

            if ( $action == 'view' && $sh->action == 'edit' ) {
                return true;
            }

            if ( $action == 'download' ) {
                return true;
            }

            return false;
        }
    }

    public function isAdmin() {

        return $this->role_id === 1 || $this->role_id === 3;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storedCards() {

        return $this->hasMany( CcStoredUserCard::class );
    }

    public function paymentDefault() {

        return $this->storedCards()->where( 'default', 1 );
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function packageReccuringPayments() {

        return $this->hasOne( PackageReccuringPayment::class );
    }

    public function failedAttempts() {
        return $this->hasOne( FailedAttemptPayment::class );
    }

    public function feedback() {
        return $this->hasMany( Feedback::class );
    }

}
