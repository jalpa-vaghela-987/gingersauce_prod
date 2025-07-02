<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CcStoredUserCard extends Model{

    use SoftDeletes;

    protected $fillable = [ 'client_id', 'buyer_card_mask', 'custom_client_id', 'cc_card_type', 'token_id', 'token', 'name_on_card', 'default' ];

    public function user(){

        return $this->hasOne( User::class );
    }
}
