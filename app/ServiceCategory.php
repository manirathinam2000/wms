<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{

	protected $table='service_category';

	protected $fillable = [
		'service_category_name'
	];

}
