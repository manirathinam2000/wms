<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
	protected $table='payment_status';

	protected $fillable = [
		'payment_status_name'
	];

}
