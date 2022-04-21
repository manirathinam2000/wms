<?php

namespace App\Http\Controllers;

use App\Employee;
use App\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class ServiceCategoryController extends Controller
{
	public function index()
	{
		$data = ServiceCategory::latest()->get();

		return view('service_category.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(ServiceCategory::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('service_category_name'),
				[
					'service_category_name' => 'required|unique:service_category,service_category_name,',
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['service_category_name'] = $request->service_category_name;

			ServiceCategory::create($data);

			return redirect()->route('service_category.index');
		
	}

	public function create()
	{
		return view('service_category.create');
	}


	public function edit($id)
	{

		$data = ServiceCategory::findOrFail($id);
		return view('service_category.edit', compact('data'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('service_category_name');

				$validator = Validator::make($request->only('service_category_name'),
				[
					'service_category_name' => 'required|unique:service_category,service_category_name,' . $id,
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			ServiceCategory::whereId($id)->update($data);

			return redirect()->route('service_category.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-service_category'))
		{
		     ServiceCategory::whereId($id)->delete();
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

		if ($logged_user->can('delete-service_category'))
		{

			$service_category_id = $request['service_categoryIdArray'];
			$service_category = ServiceCategory::whereIn('id', $service_category_id);
			if ($service_category->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.service_category')])]);
			}
			else {
				return response()->json(['error' => 'Error selected service_categorys can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
