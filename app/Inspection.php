<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{

	protected $fillable = [
		'ref_no','date_time','job_id','location_id','is_billing','service_book','spare_wheel','jack','radio', 'cassette', 'antenna', 'wipers', 'cig_lighter', 'wheel_cap', 'air_conditioner', 'head_rest', 'tools', 'front_left', 'front_right', 'rear_left', 'rear_right', 'head_light', 'front_park_light', 'rear_red_light', 'turn_signals', 'fire_extinguisher', 'inside_mirror',  'mirror_lh', 'mileage', 'odometer', 'mirror_rh', 'is_approved', 'fuel'
	];

}
