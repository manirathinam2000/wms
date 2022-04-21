<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class EmployeeController extends Controller
{
	public function index()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$data = Employee::latest()->get();

		return view('employee.index', compact('data', 'countries'));
	}

	public function get_data()
	{
		
			return datatables()->of(Employee::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('employee_name', 'employee_id', 'category_id'),
				[
					'employee_name' => 'required|unique:employees,employee_name,',
					'employee_id' => 'required',
					'category_id'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['employee_name'] = $request->employee_name;
			$data['employee_id'] = $request->employee_id;
			$data ['category_id'] = $request->category_id;
			$data ['shift_start_time'] = $request->shift_start_time;
			$data ['shift_end_time'] = $request->shift_end_time;
			$data ['nationality'] = $request->nationality;
			$data ['doj'] = $request->doj;
			$data ['basic'] = $request->basic;
			if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;

			Employee::create($data);


			return redirect()->route('employee.index');
		
	}

	public function create()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$categorys = \DB::table('employee_category')->select('id','employee_category_name')->get();
		return view('employee.create', compact( 'categorys'));
	}


	public function edit($id)
	{
		$categorys = \DB::table('employee_category')->select('id','employee_category_name')->get();
		$data = Employee::findOrFail($id);
		return view('employee.edit', compact('data', 'categorys'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('employee_name','employee_id','category_id','shift_start_time','shift_end_time','nationality','doj','basic', 'is_active');

				if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;

				$validator = Validator::make($request->only('employee_name', 'employee_id', 'category_id'),
				[
					'employee_name' => 'required|unique:employees,employee_name,' . $id,
					'employee_id' => 'required',
					'category_id'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			Employee::whereId($id)->update($data);

			return redirect()->route('employee.index');
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-employee'))
		{
		     Employee::whereId($id)->delete();
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

		if ($logged_user->can('delete-employee'))
		{

			$employee_id = $request['employeeIdArray'];
			$employee = Employee::whereIn('id', $employee_id);
			if ($employee->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.employee')])]);
			}
			else {
				return response()->json(['error' => 'Error selected employees can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
