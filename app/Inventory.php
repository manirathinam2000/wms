<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{

	protected $fillable = [
		'branch_id','type_id','type_ref_id','trans_date','remarks','is_active'
	];

}
