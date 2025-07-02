<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
	protected $fillable = ['owner_id', 'user_id', 'action', 'brandbook_id'];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
