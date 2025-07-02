<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referrers extends Model
{
    protected $fillable = ['email', 'user_id', 'link'];
}
