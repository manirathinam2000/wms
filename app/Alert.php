<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
	protected $fillable = [
		'alert_list_id', 'alert_schedule', 'alert_desc', 'alert_start_date'
	];

}
