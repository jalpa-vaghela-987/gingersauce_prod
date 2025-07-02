<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Theme extends \Eloquent{


    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive( Builder $query ){
        return $query->where( 'is_active', true );
    }
}
