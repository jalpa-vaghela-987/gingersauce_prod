<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabContent extends Model
{

    protected $fillable = ['tab_id', 'title', 'description', 'image', 'width', 'height', 'status'];

    public function tabs() {
        return $this->belongsTo( 'App\Tab');
    }
}
