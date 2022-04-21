<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;

class ServiceController extends Controller
{
	public function index()
	{
		
		$data = Service::leftJoin('service_category as s', 's.id', 'services.service_category_id')->get();

		return view('service.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(Service::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('service_name', 'service_category_id'),
				[
					'service_name' => 'required|unique:services,service_name,',
					'service_category_id' => 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['service_name'] = $request->service_name;
			$data ['service_category_id'] = $request->service_category_id;
			if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;

			Service::create($data);

			return redirect()->route('service.index');
		
	}

	public function create()
	{
		$service_categorys = \DB::table('service_category')->select('id','service_category_name')->get();
		return view('service.create', compact( 'service_categorys'));
	}


	public function edit($id)
	{

		$service_categorys = \DB::table('service_category')->select('id','service_category_name')->get();
		
			$data = Service::findOrFail($id);
			return view('service.edit', compact('data', 'service_categorys'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('service_name', 'service_category_id');
			if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;

			$validator = Validator::make($request->only('service_name', 'service_category_id'),
				[
					'service_name' => 'required|unique:services,service_name,' . $id,
					'service_category_id' => 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			Service::whereId($id)->update($data);

			return redirect()->route('service.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-bay'))
		{
		     Service::whereId($id)->delete();
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

		if ($logged_user->can('delete-bay'))
		{

			$bay_id = $request['bayIdArray'];
			$bay = Service::whereIn('id', $bay_id);
			if ($bay->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.bay')])]);
			}
			else {
				return response()->json(['error' => 'Error selected bays can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
