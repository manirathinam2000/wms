<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderBooking extends Model
{

	protected $fillable = [
		'vendor_invoice_number','invoice_date','invoice_amount','submitted_date','goods_receipt','payment_status_id','payment_date'
	];

}
