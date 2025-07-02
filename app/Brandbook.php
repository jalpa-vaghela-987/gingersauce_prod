<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brandbook extends Model{

    use SoftDeletes;

    const BOOK_STATUSES_PUBLIC = 'public';
    const BOOK_STATUSES_DRAFT  = 'draft';
    const BOOK_STATUSES_TRASH  = 'trash';

    protected $dates = [ 'created_at', 'updated_at', 'expires_at' ];
    protected $casts
                     = [
            'new_color_scheme' => 'array',
        ];

    public function user(){

        return $this->belongsTo( 'App\User' );
    }

    public function industry_1(){

        return $this->hasOne( 'App\Industry', 'id', 'industry_level_1' );
    }

    public function industry_2(){

        return $this->hasOne( 'App\Industry', 'id', 'industry_level_2' );
    }

    public function human_date(){

        return Carbon::parse( $this->updated_at )->since( Carbon::now(), [ 'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW ] );
    }

    public function industries_title(){

        $first  = $this->industry_1;
        $second = $this->industry_2;
        $is     = [];
        if ( isset( $i1->title ) )
            $is[] = $first->title;
        if ( isset( $i2->title ) )
            $is[] = $second->title;
        // if($i2!=null && !empty(trim($i2->title)))
        // $is[]=$i2->id;
        // print_r($is);
        return join( ' & ', $is );
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic( $query ){

        return $query->where( 'status', 'public' );
    }

    public function shares(){

        return $this->hasMany( 'App\Share' );
    }

    public function getCustomAttribute( $value ){

        return unserialize( $value );
    }

    public function setCustomAttribute( $value ){

        $this->attributes[ 'custom' ] = serialize( $value );
    }

    public function bookReccuringPayment(){
        return $this->hasOne(BooksReccuringPayment::class,'book_id', 'id');
    }

    public function setVoicesAttribute($value){
        $this->attributes['voices'] = serialize($value);
    }

    public function getVoicesAttribute($value){
        return unserialize($value);
    }

    public function finished(){
        return $this->version > 2 ? $this->completed === 25 : $this->completed === 24;
    }

    public function invoices() {
        return $this->hasMany( Invoice::class, 'book_id', 'id' );
    }
    public function lastInvoice() {
        return $this->invoices()->latest();
    }
    public function filterExpirationBrandBook($brandBook, $expirationDay, $past = false) {
        if($past) {
            return (Carbon::parse($brandBook->expires_at)->addDays($expirationDay)->format('Y-m-d') == Carbon::now()->format('Y-m-d')) ? true : false;
        } else {
            return (Carbon::parse($brandBook->expires_at)->subDays($expirationDay)->format('Y-m-d') == Carbon::now()->format('Y-m-d')) ? true : false;
        }
    }
    public function publicUsers() {
        return $this->hasMany( 'App\Share' )->whereNull('user_id')->count();
    }

    public function loggedInUsers() {
        return $this->hasMany( 'App\Share' )->whereNotNull('user_id')->count();
    }

    public function tabs() {
        return $this->hasMany( 'App\Tab', 'book_id', 'id');
    }

    public function tabCount() {
        return $this->hasMany( 'App\Tab', 'book_id', 'id')->count();
    }

    public function watermarkBookinvoices() {
        return $this->hasMany( Invoice::class, 'watermark_book_id', 'id' );
    }

    public function watermarkLastInvoice() {
        return $this->watermarkBookinvoices()->latest();
    }
}
