<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

	protected $fillable = [
		'vehicle_registration_number','sufix','description','model_id','vin','engine_no','engine','color','trims', 'std_fitment', 'reg_type', 'category_type_id', 'category_id', 'key_no', 'customer_name', 'owner_name', 'remarks', 'active_status', 'amc_status', 'registration_expiry', 'insurance_policy_number', 'premium_amount', 'insurance_expiry', 'purchase_date', 'purchase_cost', 'asset_structure', 'fuel_card_number_id', 'file_1', 'file_2', 'column1', 'column2', 'column3', 'column4', 'column5'
	];

}
