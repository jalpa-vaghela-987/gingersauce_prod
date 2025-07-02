<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FailedAttemptPayment extends Model {
    public $fillable = [ 'attempts' ];
}
