<?php

namespace App\Http\Controllers;

use App\Employee;
use App\PartType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class PartTypeController extends Controller
{
	public function index()
	{
		$data = PartType::latest()->get();

		return view('part_type.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(PartType::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('part_type_name'),
				[
					'part_type_name' => 'required|unique:part_type,part_type_name,',
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['part_type_name'] = $request->part_type_name;

			PartType::create($data);

			return redirect()->route('part_type.index');
		
	}

	public function create()
	{
		return view('part_type.create');
	}


	public function edit($id)
	{
			$data = PartType::findOrFail($id);
			return view('part_type.edit', compact('data'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('part_type_name');

				$validator = Validator::make($request->only('part_type_name'),
				[
					'part_type_name' => 'required|unique:part_type,part_type_name,' . $id,
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			PartType::whereId($id)->update($data);

			return redirect()->route('part_type.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-part_type'))
		{
		     PartType::whereId($id)->delete();
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

		if ($logged_user->can('delete-part_type'))
		{

			$part_type_id = $request['part_typeIdArray'];
			$part_type = PartType::whereIn('id', $part_type_id);
			if ($part_type->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.part_type')])]);
			}
			else {
				return response()->json(['error' => 'Error selected part_types can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
