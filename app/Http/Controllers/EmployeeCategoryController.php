<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class EmployeeCategoryController extends Controller
{
	public function index()
	{
		$data = EmployeeCategory::latest()->get();

		return view('employee_category.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(EmployeeCategory::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('employee_category_name'),
				[
					'employee_category_name' => 'required|unique:employee_category,employee_category_name,',
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['employee_category_name'] = $request->employee_category_name;

			EmployeeCategory::create($data);

			return redirect()->route('employee_category.index');
		
	}

	public function create()
	{
		return view('employee_category.create');
	}


	public function edit($id)
	{
			$data = EmployeeCategory::findOrFail($id);
			return view('employee_category.edit', compact('data'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('employee_category_name');

				$validator = Validator::make($request->only('employee_category_name'),
				[
					'employee_category_name' => 'required|unique:employee_category,employee_category_name,' . $id,
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			EmployeeCategory::whereId($id)->update($data);

			return redirect()->route('employee_category.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-employee_category'))
		{
		     EmployeeCategory::whereId($id)->delete();
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

		if ($logged_user->can('delete-employee_category'))
		{

			$employee_category_id = $request['employee_categoryIdArray'];
			$employee_category = EmployeeCategory::whereIn('id', $employee_category_id);
			if ($employee_category->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.employee_category')])]);
			}
			else {
				return response()->json(['error' => 'Error selected employee_categorys can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
