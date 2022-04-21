<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

	protected $fillable = [
		'task_category_id','task_type_id','task_list_id','day_of_service','km_of_service','status_id','auto_update','standard_time','rate_per_hour', 'sub_task_01', 'spare_part_01', 'sub_task_02', 'spare_part_02', 'sub_task_03', 'spare_part_03', 'sub_task_04', 'spare_part_04', 'sub_task_05', 'spare_part_05', 'sub_task_06', 'spare_part_06', 'sub_task_07', 'spare_part_07', 'sub_task_08', 'spare_part_08', 'sub_task_09', 'spare_part_09', 'sub_task_10', 'spare_part_10'
	];

}
