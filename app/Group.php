<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    public function user(){

        return $this->belongsTo('App\User');
    }

    public function groups(){

        return $this->hasMany('App\Group');
    }

    
}
