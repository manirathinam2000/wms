<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

	protected $fillable = [
		'service_name','service_category_id','is_active'
	];

}
