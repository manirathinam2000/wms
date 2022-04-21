<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model
{

	protected $fillable = [
		'inventory_id','parts_id','quantity','remarks','is_active'
	];

}
