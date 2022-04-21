<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartCategory extends Model
{

	protected $table='part_category'; 

	protected $fillable = [
		'part_category_name'
	];

}
