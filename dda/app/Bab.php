<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bab extends Model
{
	protected $fillable = [
        'id', 'nomorbab', 'bab', 'nama_bab', 'nama_eng'
    ];

    public function subbabs()
    {
    	return $this->hasMany('App\Subbab','bab', 'id');
    }
}
