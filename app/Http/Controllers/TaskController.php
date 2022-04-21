<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class TaskController extends Controller
{
	public function index()
	{
		$data = Task::leftJoin('task_lists as l', 'l.id', 'tasks.task_list_id')
					->leftJoin('task_categories as c', 'c.id', 'tasks.task_category_id')
					->leftJoin('task_types as t', 't.id', 'tasks.task_type_id')
					->leftJoin('task_statuses as s', 's.id', 'tasks.status_id')
					->get();

		
		$statuses = \DB::table('task_statuses')->select('id','task_status_name')->get();

		return view('task.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(Task::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('task_category_id', 'task_type_id', 'task_list_id'),
				[
					'task_type_id' => 'required',
					'task_category_id' => 'required',
					'task_list_id'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['task_category_id'] = $request->task_category_id;
			$data['task_type_id'] = $request->task_type_id;
			$data ['task_list_id'] = $request->task_list_id;
			$data ['day_of_service'] = $request->day_of_service;
			$data ['km_of_service'] = $request->km_of_service;
			$data ['status_id'] = $request->status_id;
			if(isset($request->auto_update))
				$data ['auto_update'] = 1;
			else
				$data ['auto_update'] = 0;
			$data ['standard_time'] = $request->standard_time;
			$data ['rate_per_hour'] = $request->rate_per_hour;
			$data ['sub_task_01'] = $request->sub_task_01;
			$data ['spare_part_01'] = $request->spare_part_01;
			$data ['sub_task_02'] = $request->sub_task_02;
			$data ['spare_part_02'] = $request->spare_part_02;
			$data ['sub_task_03'] = $request->sub_task_03;
			$data ['spare_part_03'] = $request->spare_part_03;
			$data ['sub_task_04'] = $request->sub_task_04;
			$data ['spare_part_04'] = $request->spare_part_04;
			$data ['sub_task_05'] = $request->sub_task_05;
			$data ['spare_part_05'] = $request->spare_part_05;
			$data ['sub_task_06'] = $request->sub_task_06;
			$data ['spare_part_06'] = $request->spare_part_06;
			$data ['sub_task_07'] = $request->sub_task_07;
			$data ['spare_part_07'] = $request->spare_part_07;
			$data ['sub_task_08'] = $request->sub_task_08;
			$data ['spare_part_08'] = $request->spare_part_08;
			$data ['sub_task_09'] = $request->sub_task_09;
			$data ['spare_part_09'] = $request->spare_part_09;
			$data ['sub_task_10'] = $request->sub_task_10;
			$data ['spare_part_10'] = $request->spare_part_10;

			dd($data);

			Task::create($data);


			return redirect()->route('task.index');
		
	}

	public function create()
	{
		$lists = \DB::table('task_lists')->select('id','task_list_name')->get();
		$types = \DB::table('task_types')->select('id','task_type_name')->get();
		$categorys = \DB::table('task_categories')->select('id','task_category_name')->get();
		$statuses = \DB::table('task_statuses')->select('id','task_status_name')->get();
		$parts = \DB::table('parts')->select('id','part_name')->get();
		return view('task.create', compact('lists', 'types', 'categorys', 'statuses', 'parts'));
	}


	public function edit($id)
	{
		$lists = \DB::table('task_lists')->select('id','task_list_name')->get();
		$types = \DB::table('task_types')->select('id','task_type_name')->get();
		$categorys = \DB::table('task_categories')->select('id','task_category_name')->get();
		$statuses = \DB::table('task_statuses')->select('id','task_status_name')->get();
		$parts = \DB::table('parts')->select('id','part_name')->get();
		$data = Task::findOrFail($id);
		return view('task.edit', compact('data', 'lists', 'types', 'categorys', 'statuses', 'parts'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('task_category_id','task_type_id','task_list_id','day_of_service','km_of_service','status_id','auto_update','standard_time','rate_per_hour', 'sub_task_01', 'spare_part_01', 'sub_task_02', 'spare_part_02', 'sub_task_03', 'spare_part_03', 'sub_task_04', 'spare_part_04', 'sub_task_05', 'spare_part_05', 'sub_task_06', 'spare_part_06', 'sub_task_07', 'spare_part_07', 'sub_task_08', 'spare_part_08', 'sub_task_09', 'spare_part_09', 'sub_task_10', 'spare_part_10');

				if(isset($request->auto_update))
				$data ['auto_update'] = 1;
			else
				$data ['auto_update'] = 0;

				$validator = Validator::make($request->only('task_category_id', 'task_type_id', 'task_list_id'),
				[
					'task_type_id' => 'required',
					'task_category_id' => 'required',
					'task_list_id'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			Task::whereId($id)->update($data);

			return redirect()->route('task.index');
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-task'))
		{
		     Task::whereId($id)->delete();
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

		if ($logged_user->can('delete-task'))
		{

			$task_id = $request['taskIdArray'];
			$task = Task::whereIn('id', $task_id);
			if ($task->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.task')])]);
			}
			else {
				return response()->json(['error' => 'Error selected tasks can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
