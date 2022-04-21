<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class VendorController extends Controller
{
	public function index()
	{
		$data = Vendor::latest()->get();

		return view('vendor.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(Vendor::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('vendor_name', 'address1', 'city',
				 'country'),
				[
					'vendor_name' => 'required|unique:vendors,vendor_name,',
					'address1' => 'required',
					'country'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			$data = [];

			$data['vendor_name'] = $request->vendor_name;
			$data['ref_code'] = $request->ref_code;
			$data['cr_number'] = $request->cr_number;
			$data['category_id'] = $request->category_id;
			$data['tax_number'] = $request->tax_number;
			$data['address1'] = $request->address1;
			$data['address2'] = $request->address2;
			$data['city'] = $request->city;
			$data['country'] = $request->country;
			$data['contact_person'] = $request->contact_person;
			$data['mobile'] = $request->mobile;
			$data['email'] = $request->email;
			$data['debtor_in_charge'] = $request->debtor_in_charge;
			$data['currency'] = $request->currency;
			$data['credit_amount'] = $request->credit_amount;
			$data['credit_days'] = $request->credit_days;
			$data['opening_balance'] = $request->opening_balance;
			$data['payment_type_id'] = $request->payment_type_id;
			$data['remarks'] = $request->remarks;
			$data['column1'] = $request->column1;
			$data['column2'] = $request->column2;
			$data['column3'] = $request->column3;
			$data['column4'] = $request->column4;
			$data['column5'] = $request->column5;

			Vendor::create($data);


			return redirect()->route('vendor.index');
		
	}

	public function create()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$categorys = \DB::table('vendor_category')->select('id','vendor_category_name')->get();
		$payment_types = \DB::table('payment_types')->select('id','payment_type_name')->get();
		return view('vendor.create',  compact('countries', 'categorys', 'payment_types'));
	}


	public function edit($id)
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$categorys = \DB::table('vendor_category')->select('id','vendor_category_name')->get();
		$payment_types = \DB::table('payment_types')->select('id','payment_type_name')->get();
		
		$data = Vendor::findOrFail($id);
		return view('vendor.edit',  compact('data', 'countries', 'categorys', 'payment_types'));
	}






	public function update(Request $request)
	{
		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('vendor_name','ref_code','cr_number','category_id','tax_number','address1','address2','city','country','contact_person','mobile','email', 'debtor_in_charge', 'currency', 'credit_amount', 'credit_days', 'opening_balance', 'payment_type_id', 'remarks', 'column1', 'column2', 'column3', 'column4', 'column5');

				$validator = Validator::make($data ,
			   [
				   'vendor_name' => 'required|unique:vendors,vendor_name,' . $id,
				   'address1' => 'required',
				   'country'=> 'required'
			   ]
		   );


		   if ($validator->fails())
		   {
			   return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		   }


			Vendor::whereId($id)->update($data);

			return redirect()->route('vendor.index');
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-vendor'))
		{
		     Vendor::whereId($id)->delete();
		     return "success";

		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	public function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-vendor'))
		{

			$vendor_id = $request['vendorIdArray'];
			$vendor = Vendor::whereIn('id', $vendor_id);
			if ($vendor->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.vendor')])]);
			}
			else {
				return response()->json(['error' => 'Error selected vendors can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
