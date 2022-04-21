<?php

namespace App\Http\Controllers;

use App\Employee;
use App\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class TaskStatusController extends Controller
{
	public function index()
	{

		$data = TaskStatus::latest()->get();
		return view('task_status.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(TaskStatus::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('task_status_name'),
			[
				'task_status_name' => 'required|unique:task_statuses,task_status_name,',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['task_status_name'] = $request->task_status_name;

		TaskStatus::create($data);

		return redirect()->route('task_status.index');
		
	}

	public function create()
	{
		return view('task_status.create');
	}


	public function edit($id)
	{
		$data = TaskStatus::findOrFail($id);
		return view('task_status.edit', compact('data'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('task_status_name');


		$validator = Validator::make($request->only('task_status_name'),
			[
				'task_status_name' => 'required|unique:task_statuses,task_status_name,' . $id,
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		TaskStatus::whereId($id)->update($data);

		return redirect()->route('task_status.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-task_status'))
		{
		     TaskStatus::whereId($id)->delete();
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

		if ($logged_user->can('delete-task_status'))
		{

			$task_status_id = $request['task_statusIdArray'];
			$task_status = TaskStatus::whereIn('id', $task_status_id);
			if ($task_status->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.task_status')])]);
			}
			else {
				return response()->json(['error' => 'Error selected task_statuss can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
