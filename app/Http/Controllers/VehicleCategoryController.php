<?php

namespace App\Http\Controllers;

use App\Employee;
use App\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class VehicleCategoryController extends Controller
{
	public function index()
	{

		$data = VehicleCategory::latest()->get();
		return view('vehicle_category.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(VehicleCategory::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('vehicle_category_name'),
			[
				'vehicle_category_name' => 'required|unique:vehicle_category,vehicle_category_name,',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['vehicle_category_name'] = $request->vehicle_category_name;

		VehicleCategory::create($data);

		return redirect()->route('vehicle_category.index');
		
	}

	public function create()
	{
		return view('vehicle_category.create');
	}


	public function edit($id)
	{
		$data = VehicleCategory::findOrFail($id);
		return view('vehicle_category.edit', compact('data'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('vehicle_category_name');


		$validator = Validator::make($request->only('vehicle_category_name'),
			[
				'vehicle_category_name' => 'required|unique:vehicle_category,vehicle_category_name,' . $id,
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		VehicleCategory::whereId($id)->update($data);

		return redirect()->route('vehicle_category.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-vehicle_category'))
		{
		     VehicleCategory::whereId($id)->delete();
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

		if ($logged_user->can('delete-vehicle_category'))
		{

			$vehicle_category_id = $request['vehicle_categoryIdArray'];
			$vehicle_category = VehicleCategory::whereIn('id', $vehicle_category_id);
			if ($vehicle_category->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.vehicle_category')])]);
			}
			else {
				return response()->json(['error' => 'Error selected vehicle_categorys can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
