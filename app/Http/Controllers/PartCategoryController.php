<?php

namespace App\Http\Controllers;

use App\Employee;
use App\PartCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class PartCategoryController extends Controller
{
	public function index()
	{
		$data = PartCategory::latest()->get();

		return view('part_category.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(PartCategory::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('part_category_name'),
				[
					'part_category_name' => 'required|unique:part_category,part_category_name,',
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['part_category_name'] = $request->part_category_name;

			PartCategory::create($data);

			return redirect()->route('part_category.index');
		
	}

	public function create()
	{
		return view('part_category.create');
	}


	public function edit($id)
	{
			$data = PartCategory::findOrFail($id);
			return view('part_category.edit', compact('data'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('part_category_name');

				$validator = Validator::make($request->only('part_category_name'),
				[
					'part_category_name' => 'required|unique:part_category,part_category_name,' . $id,
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			PartCategory::whereId($id)->update($data);

			return redirect()->route('part_category.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-part_category'))
		{
		     PartCategory::whereId($id)->delete();
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

		if ($logged_user->can('delete-part_category'))
		{

			$part_category_id = $request['part_categoryIdArray'];
			$part_category = PartCategory::whereIn('id', $part_category_id);
			if ($part_category->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.part_category')])]);
			}
			else {
				return response()->json(['error' => 'Error selected part_categorys can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
