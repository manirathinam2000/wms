<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{

	protected $table='vendor_category'; 

	protected $fillable = [
		'vendor_category_name'
	];

}
