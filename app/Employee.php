<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

	protected $fillable = [
		'employee_name','employee_id','category_id','shift_start_time','shift_end_time','nationality','doj','basic', 'is_active'
	];

}
