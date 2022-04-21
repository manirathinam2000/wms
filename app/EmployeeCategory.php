<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeCategory extends Model
{

	protected $table='employee_category'; 

	protected $fillable = [
		'employee_category_name'
	];

}
