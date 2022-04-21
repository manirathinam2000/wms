<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class location extends Model
{
	protected $fillable = [
		'location_name','address1','address2','city','country','contact_person','mobile','email',
	];

	public function country(){
		return $this->hasOne('App\Country','id','country');
	}

	public function LocationHead(){
		return $this->hasOne('App\Employee','id','location_head');
	}


}
