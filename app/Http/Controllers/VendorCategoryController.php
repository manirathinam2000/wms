<?php

namespace App\Http\Controllers;

use App\Employee;
use App\VendorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class VendorCategoryController extends Controller
{
	public function index()
	{
		$data = VendorCategory::latest()->get();

		return view('vendor_category.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(VendorCategory::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('vendor_category_name'),
				[
					'vendor_category_name' => 'required|unique:vendor_category,vendor_category_name,',
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['vendor_category_name'] = $request->vendor_category_name;

			VendorCategory::create($data);

			return redirect()->route('vendor_category.index');
		
	}

	public function create()
	{
		return view('vendor_category.create');
	}


	public function edit($id)
	{
			$data = VendorCategory::findOrFail($id);
			return view('vendor_category.edit', compact('data'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('vendor_category_name');

				$validator = Validator::make($request->only('vendor_category_name'),
				[
					'vendor_category_name' => 'required|unique:vendor_category,vendor_category_name,' . $id,
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			VendorCategory::whereId($id)->update($data);

			return redirect()->route('vendor_category.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-vendor_category'))
		{
		     VendorCategory::whereId($id)->delete();
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

		if ($logged_user->can('delete-vendor_category'))
		{

			$vendor_category_id = $request['vendor_categoryIdArray'];
			$vendor_category = VendorCategory::whereIn('id', $vendor_category_id);
			if ($vendor_category->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.vendor_category')])]);
			}
			else {
				return response()->json(['error' => 'Error selected vendor_categorys can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
