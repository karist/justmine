<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subbab extends Model
{
    public function bab(){
    	return $this->belongsTo('App\Bab', 'bab', 'id');
    }
}