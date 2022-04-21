<?php

namespace App\Http\Controllers;

use App\Employee;
use App\TaskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class TaskCategoryController extends Controller
{
	public function index()
	{

		$data = TaskCategory::latest()->get();
		return view('task_category.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(TaskCategory::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('task_category_name'),
			[
				'task_category_name' => 'required|unique:task_categories,task_category_name,',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['task_category_name'] = $request->task_category_name;

		TaskCategory::create($data);

		return redirect()->route('task_category.index');
		
	}

	public function create()
	{
		return view('task_category.create');
	}


	public function edit($id)
	{
		$data = TaskCategory::findOrFail($id);
		return view('task_category.edit', compact('data'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('task_category_name');


		$validator = Validator::make($request->only('task_category_name'),
			[
				'task_category_name' => 'required|unique:task_categories,task_category_name,' . $id,
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		TaskCategory::whereId($id)->update($data);

		return redirect()->route('task_category.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-task_category'))
		{
		     TaskCategory::whereId($id)->delete();
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

		if ($logged_user->can('delete-task_category'))
		{

			$task_category_id = $request['task_categoryIdArray'];
			$task_category = TaskCategory::whereIn('id', $task_category_id);
			if ($task_category->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.task_category')])]);
			}
			else {
				return response()->json(['error' => 'Error selected task_categorys can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
