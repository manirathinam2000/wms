<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{

	protected $fillable = [
		'part_name','article_number','oem_part_number','part_description','make','model','type_id','category_id','uom_id', 'purchase_price', 'selling_price', 'max_discount', 'reorder_level', 'location_id', 'is_active', 'column1', 'column2', 'column3', 'column4', 'column5'
	];

}
