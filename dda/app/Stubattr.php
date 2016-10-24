<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stubattr extends Model
{
    protected $fillable = ['stubname', 'stubindo', 'stubeng'];

    public function subCategory(){
        return $this->hasMany('App\Stub', 'stubname');
    }
}
