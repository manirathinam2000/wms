<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{

	protected $table='vehicle_category';

	protected $fillable = [
		'vehicle_category_name'
	];

}
