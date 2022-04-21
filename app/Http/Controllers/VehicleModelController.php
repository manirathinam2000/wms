<?php

namespace App\Http\Controllers;

use App\Employee;
use App\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class VehicleModelController extends Controller
{
	public function index()
	{

		$data = VehicleModel::latest()->get();
		return view('vehicle_model.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(VehicleModel::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('vehicle_model_name'),
			[
				'vehicle_model_name' => 'required|unique:vehicle_models,vehicle_model_name,',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['vehicle_model_name'] = $request->vehicle_model_name;

		VehicleModel::create($data);

		return redirect()->route('vehicle_model.index');
		
	}

	public function create()
	{
		return view('vehicle_model.create');
	}


	public function edit($id)
	{
		$data = VehicleModel::findOrFail($id);
		return view('vehicle_model.edit', compact('data'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('vehicle_model_name');


		$validator = Validator::make($request->only('vehicle_model_name'),
			[
				'vehicle_model_name' => 'required|unique:vehicle_models,vehicle_model_name,' . $id,
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		VehicleModel::whereId($id)->update($data);

		return redirect()->route('vehicle_model.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-vehicle_model'))
		{
		     VehicleModel::whereId($id)->delete();
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

		if ($logged_user->can('delete-vehicle_model'))
		{

			$vehicle_model_id = $request['vehicle_modelIdArray'];
			$vehicle_model = VehicleModel::whereIn('id', $vehicle_model_id);
			if ($vehicle_model->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.vehicle_model')])]);
			}
			else {
				return response()->json(['error' => 'Error selected vehicle_models can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
