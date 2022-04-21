<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{

	protected $fillable = [
		'vendor_name','ref_code','cr_number','category_id','tax_number','address1','address2','city','country','contact_person','mobile','email', 'debtor_in_charge', 'currency', 'credit_amount', 'credit_days', 'opening_balance', 'payment_type_id', 'remarks', 'column1', 'column2', 'column3', 'column4', 'column5'
	];

}
