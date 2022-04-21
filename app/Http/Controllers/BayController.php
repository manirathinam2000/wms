<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Bay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class BayController extends Controller
{
	public function index()
	{
		$data = Bay::leftJoin('locations as l', 'l.id', 'bay.location_id')
				   ->leftJoin('task_types as t', 't.id', 'bay.task_type_id')
				   ->get();

		return view('bay.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(Bay::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('bay_name', 'location_id', 'task_type_id'),
				[
					'bay_name' => 'required|unique:bay,bay_name,',
					'location_id' => 'required',
					'task_type_id'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['bay_name'] = $request->bay_name;
			$data ['location_id'] = $request->location_id;
			$data ['task_type_id'] = $request->task_type_id;


			Bay::create($data);

			return redirect()->route('bay.index');
		
	}

	public function create()
	{
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$task_types = \DB::table('task_types')->select('id','task_type_name')->get();
		return view('bay.create', compact( 'locations', 'task_types'));
	}


	public function edit($id)
	{
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$task_types = \DB::table('task_types')->select('id','task_type_name')->get();

		$data = Bay::findOrFail($id);

		return view('bay.edit', compact('data','locations', 'task_types'));

	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('bay_name', 'location_id', 'task_type_id');

				$validator = Validator::make($request->only('bay_name', 'location_id', 'task_type_id'),
				[
					'bay_name' => 'required|unique:bay,bay_name,' . $id,
					'location_id' => 'required',
					'task_type_id'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			Bay::whereId($id)->update($data);

			return redirect()->route('bay.index');
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
		     Bay::whereId($id)->delete();
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
			$bay = Bay::whereIn('id', $bay_id);
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
