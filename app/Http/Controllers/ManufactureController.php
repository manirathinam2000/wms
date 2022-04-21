<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Manufacture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class ManufactureController extends Controller
{
	public function index()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$data = Manufacture::latest()->get();

		return view('manufacture.index', compact('data', 'countries'));
	}

	public function get_data()
	{
		
			return datatables()->of(Manufacture::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('manufacture_name', 'address1', 'city',
				 'country'),
				[
					'manufacture_name' => 'required|unique:manufactures,manufacture_name,',
					'address1' => 'required',
					'country'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['manufacture_name'] = $request->manufacture_name;
			$data['sap_ref_code'] = $request->sap_ref_code;
			$data ['address1'] = $request->address1;
			$data ['address2'] = $request->address2;
			$data ['city'] = $request->city;
			$data ['country'] = $request->country;
			$data ['contact_person'] = $request->contact_person;
			$data ['mobile'] = $request->mobile;
			$data ['email'] = $request->email;
			if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;

			Manufacture::create($data);


			return redirect()->route('manufacture.index');
		
	}

	public function create()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		return view('manufacture.create', compact( 'countries'));
	}


	public function edit($id)
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$data = Manufacture::findOrFail($id);
		return view('manufacture.edit', compact('data', 'countries'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('manufacture_name','sap_ref_code','address1','address2','city','country','contact_person','mobile','email', 'is_active');

				if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;

				$validator = Validator::make($request->only('manufacture_name', 'address1', 'city',
				'country'),
			   [
				   'manufacture_name' => 'required|unique:manufactures,manufacture_name,' . $id,
				   'address1' => 'required',
				   'country'=> 'required'
			   ]
		   );


		   if ($validator->fails())
		   {
			   return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		   }


			Manufacture::whereId($id)->update($data);

			return redirect()->route('manufacture.index');
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-manufacture'))
		{
		     Manufacture::whereId($id)->delete();
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

		if ($logged_user->can('delete-manufacture'))
		{

			$manufacture_id = $request['manufactureIdArray'];
			$manufacture = Manufacture::whereIn('id', $manufacture_id);
			if ($manufacture->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.manufacture')])]);
			}
			else {
				return response()->json(['error' => 'Error selected manufactures can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
