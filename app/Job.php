<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

	protected $fillable = [
		'job_type_id','customer_id','service_category_id','billing_status_id','is_closed'
	];

}
