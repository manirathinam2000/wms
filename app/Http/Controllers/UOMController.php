<?php

namespace App\Http\Controllers;

use App\Employee;
use App\UOM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class UOMController extends Controller
{
	public function index()
	{
		$data = UOM::latest()->get();

		return view('uom.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(UOM::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('uom'),
				[
					'uom' => 'required|unique:uom,uom,',
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['uom'] = $request->uom;

			UOM::create($data);

			return redirect()->route('uom.index');
		
	}

	public function create()
	{
		return view('uom.create');
	}


	public function edit($id)
	{
			$data = UOM::findOrFail($id);
			return view('uom.edit', compact('data'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('uom');

				$validator = Validator::make($request->only('uom'),
				[
					'uom' => 'required|unique:uom,uom,' . $id,
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			UOM::whereId($id)->update($data);

			return redirect()->route('uom.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-uom'))
		{
		     UOM::whereId($id)->delete();
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

		if ($logged_user->can('delete-uom'))
		{

			$uom_id = $request['uomIdArray'];
			$uom = UOM::whereIn('id', $uom_id);
			if ($uom->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.uom')])]);
			}
			else {
				return response()->json(['error' => 'Error selected uoms can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
