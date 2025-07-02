<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {
    public function user() {

        return $this->belongsTo( 'App\User' );
    }

    public function package() {

        if ( $this->book_id ) {
            return $this->belongsTo( BookExtends::class );
        } else {
            return $this->belongsTo( 'App\Package' );
        }
    }

    public function scopePaid( \Illuminate\Database\Eloquent\Builder $query ) {
        return $query->where( 'status', 'paid' );
    }

    public function token() {
        return $this->hasOne( CcStoredUserCard::class, 'id', 'token_id' );
    }

    public function book() {
        return $this->hasOne( Brandbook::class, 'id', 'book_id' );
    }

    public function coupon(){
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }

    public function paidAmount(){
        if($this->coupon){
            $discount           = $this->price * ( $this->coupon->discount / 100 );
            return $this->price - $discount;
        } else {
            return  $this->price;
        }
    }

}
