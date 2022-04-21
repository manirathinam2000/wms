<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{

	protected $fillable = [
		'manufacture_name','sap_ref_code','address1','address2','city','country','contact_person','mobile','email', 'is_active'
	];

}
