<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberCollection extends Model
{
    

    public function user(){

        return $this->belongsTo('App\User');
    }

    public function group(){

        return $this->belongsTo('App\Group');
    }
}
