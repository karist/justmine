<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	public function stubname(){
		return $this->hasOne('Stubattr');
	}
}
