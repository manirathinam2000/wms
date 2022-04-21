<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelCard extends Model
{

	protected $fillable = [
		'fuel_card_number', 'fuel_card_company', 'limits', 'expiry',
	];

}
