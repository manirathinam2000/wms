<?php

namespace App\Http\Controllers;

use App\Employee;
use App\AlertList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;

class AlertListController extends Controller
{
	public function index()
	{

		$data = AlertList::latest()->get();
		return view('alert_list.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(AlertList::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('alert_list_name'),
			[
				'alert_list_name' => 'required|unique:alert_lists,alert_list_name,',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['alert_list_name'] = $request->alert_list_name;

		AlertList::create($data);

		return redirect()->route('alert_list.index');
		
	}

	public function create()
	{
		return view('alert_list.create');
	}


	public function edit($id)
	{
		$data = AlertList::findOrFail($id);
		return view('alert_list.edit', compact('data'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('alert_list_name');


		$validator = Validator::make($request->only('alert_list_name'),
			[
				'alert_list_name' => 'required|unique:alert_lists,alert_list_name,' . $id,
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		AlertList::whereId($id)->update($data);

		return redirect()->route('alert_list.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-alert_list'))
		{
		     AlertList::whereId($id)->delete();
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

		if ($logged_user->can('delete-alert_list'))
		{

			$alert_list_id = $request['alert_listIdArray'];
			$alert_list = AlertList::whereIn('id', $alert_list_id);
			if ($alert_list->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.alert_list')])]);
			}
			else {
				return response()->json(['error' => 'Error selected alert_lists can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
