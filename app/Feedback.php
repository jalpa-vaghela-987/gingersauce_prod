<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model {
    protected $fillable = [ 'feedback' ];

    public function feedback() {
        return $this->belongsTo( User::class );
    }
}
