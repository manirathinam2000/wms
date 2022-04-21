<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bay extends Model
{

	protected $table='bay';

	protected $fillable = [
		'bay_name','location_id','task_type_id'
	];

}
