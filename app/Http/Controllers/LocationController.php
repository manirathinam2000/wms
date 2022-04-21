<?php

namespace App\Http\Controllers;

use App\Employee;
use App\location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class LocationController extends Controller
{
	public function index()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$data = location::latest()->get();

		return view('location.index', compact('data', 'countries'));
	}

	public function get_data()
	{
		
			return datatables()->of(location::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('location_name', 'address1', 'city',
				 'country', 'mobile', 'email'),
				[
					'location_name' => 'required|unique:locations,location_name,',
					'address1' => 'required',
					'country'=> 'required',
					'email' => 'nullable|email|unique:users,email',
					'mobile' => 'nullable|numeric'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['location_name'] = $request->location_name;
			$data ['address1'] = $request->address1;
			$data ['address2'] = $request->address2;
			$data ['city'] = $request->city;
			$data ['country'] = $request->country;
			$data ['contact_person'] = $request->contact_person;
			$data ['mobile'] = $request->mobile;
			$data ['email'] = $request->email;


			location::create($data);

			$data = location::latest()->get();

			return redirect()->route('locations.index');
		
	}

	public function create()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		return view('location.create', compact( 'countries'));
	}


	public function edit($id)
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$data = location::findOrFail($id);

		return view('location.edit', compact('data', 'countries'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();


           $id = $request->hidden_id;

			$data = $request->only('location_name','address1','address2','city','country','contact_person','mobile','email');

			

				$validator = Validator::make($request->only('location_name', 'address1', 'city',
				'country'),
			   [
				   'location_name' => 'required|unique:locations,location_name,' . $id,
				   'address1' => 'required',
				   'country'=> 'required',
				   'email' => 'nullable|email|unique:users,email',
				   'mobile' => 'nullable|numeric'
			   ]
		   );


		   if ($validator->fails())
		   {
			   return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		   }


			location::whereId($id)->update($data);

			return redirect()->route('locations.index');

		
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-location'))
		{
		     location::whereId($id)->delete();
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

		if ($logged_user->can('delete-location'))
		{

			$location_id = $request['locationIdArray'];
			$location = location::whereIn('id', $location_id);
			if ($location->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.Location')])]);
			}
			else {
				return response()->json(['error' => 'Error selected Locations can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
