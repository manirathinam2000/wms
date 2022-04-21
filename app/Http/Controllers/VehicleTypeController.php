<?php

namespace App\Http\Controllers;

use App\Employee;
use App\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class VehicleTypeController extends Controller
{
	public function index()
	{

		$data = VehicleType::latest()->get();
		return view('vehicle_type.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(VehicleType::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('vehicle_type_name'),
			[
				'vehicle_type_name' => 'required|unique:vehicle_types,vehicle_type_name,',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['vehicle_type_name'] = $request->vehicle_type_name;

		VehicleType::create($data);

		return redirect()->route('vehicle_type.index');
		
	}

	public function create()
	{
		return view('vehicle_type.create');
	}


	public function edit($id)
	{
		$data = VehicleType::findOrFail($id);
		return view('vehicle_type.edit', compact('data'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('vehicle_type_name');


		$validator = Validator::make($request->only('vehicle_type_name'),
			[
				'vehicle_type_name' => 'required|unique:vehicle_types,vehicle_type_name,' . $id,
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		VehicleType::whereId($id)->update($data);

		return redirect()->route('vehicle_type.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-vehicle_type'))
		{
		     VehicleType::whereId($id)->delete();
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

		if ($logged_user->can('delete-vehicle_type'))
		{

			$vehicle_type_id = $request['vehicle_typeIdArray'];
			$vehicle_type = VehicleType::whereIn('id', $vehicle_type_id);
			if ($vehicle_type->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.vehicle_type')])]);
			}
			else {
				return response()->json(['error' => 'Error selected vehicle_types can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
