<?php

namespace App\Http\Controllers;

use App\Employee;
use App\TaskType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class TaskTypeController extends Controller
{
	public function index()
	{

		$data = TaskType::latest()->get();
		return view('task_type.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(TaskType::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('task_type_name'),
			[
				'task_type_name' => 'required|unique:task_types,task_type_name,',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['task_type_name'] = $request->task_type_name;

		TaskType::create($data);

		return redirect()->route('task_type.index');
		
	}

	public function create()
	{
		return view('task_type.create');
	}


	public function edit($id)
	{
		$data = TaskType::findOrFail($id);
		return view('task_type.edit', compact('data'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('task_type_name');


		$validator = Validator::make($request->only('task_type_name'),
			[
				'task_type_name' => 'required|unique:task_types,task_type_name,' . $id,
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		TaskType::whereId($id)->update($data);

		return redirect()->route('task_type.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-task_type'))
		{
		     TaskType::whereId($id)->delete();
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

		if ($logged_user->can('delete-task_type'))
		{

			$task_type_id = $request['task_typeIdArray'];
			$task_type = TaskType::whereIn('id', $task_type_id);
			if ($task_type->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.task_type')])]);
			}
			else {
				return response()->json(['error' => 'Error selected task_types can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
