<?php

namespace App\Http\Controllers;

use App\Employee;
use App\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;

class TaskListController extends Controller
{
	public function index()
	{

		$data = TaskList::latest()->get();
		return view('task_list.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(TaskList::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('task_list_name'),
			[
				'task_list_name' => 'required|unique:task_lists,task_list_name,',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['task_list_name'] = $request->task_list_name;

		TaskList::create($data);

		return redirect()->route('task_list.index');
		
	}

	public function create()
	{
		return view('task_list.create');
	}


	public function edit($id)
	{
		$data = TaskList::findOrFail($id);
		return view('task_list.edit', compact('data'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('task_list_name');


		$validator = Validator::make($request->only('task_list_name'),
			[
				'task_list_name' => 'required|unique:task_lists,task_list_name,' . $id,
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		TaskList::whereId($id)->update($data);

		return redirect()->route('task_list.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-task_list'))
		{
		     TaskList::whereId($id)->delete();
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

		if ($logged_user->can('delete-task_list'))
		{

			$task_list_id = $request['task_listIdArray'];
			$task_list = TaskList::whereIn('id', $task_list_id);
			if ($task_list->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.task_list')])]);
			}
			else {
				return response()->json(['error' => 'Error selected task_lists can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
