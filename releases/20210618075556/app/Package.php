<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Package extends Model{

    use Translatable;

    const PACKAGE_YEAR_DURATION  = 365;
    const PACKAGE_MONTH_DURATION = 30;


    const RECURRING = 'recurring';
    const MONTHLY   = 'monthly';


    protected $translatable = [ 'name', 'upper_title', 'lower_title', 'description', 'title' ];

    // SCOPES

    public function scopeFree( $query, $direction = true ){

        $comparison = $direction ? '==' : '!=';
        return $query->where( 'price', $comparison, '0.00' )
                     ->where( 'price', $comparison, '0.00' );
    }
}
