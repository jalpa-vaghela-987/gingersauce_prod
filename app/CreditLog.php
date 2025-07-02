<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditLog extends Model
{
    protected $fillable = ['comment', 'user_id', 'invoice_id', 'credits', 'type'];
}
