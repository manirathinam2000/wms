<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;

class AlertController extends Controller
{
	public function index()
	{

		$data = Alert::leftJoin('alert_lists as t', 't.id', 'alerts.alert_list_id')->get();
		return view('alert.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(Alert::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('alert_list_id', 'alert_schedule', 'alert_start_date'),
			[
				'alert_list_id' => 'required',
				'alert_schedule' => 'required',
				'alert_start_date' => 'required',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['alert_list_id'] = $request->alert_list_id;
		$data['alert_schedule'] = $request->alert_schedule;
		$data['alert_start_date'] = $request->alert_start_date;

		Alert::create($data);

		return redirect()->route('alert.index');
		
	}

	public function create()
	{
		$items = \DB::table('alert_lists')->select('id','alert_list_name')->get();
		return view('alert.create', compact('items'));
	}


	public function edit($id)
	{
		$items = \DB::table('alert_lists')->select('id','alert_list_name')->get();
		$data = Alert::findOrFail($id);
		return view('alert.edit', compact('data', 'items'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('alert_list_id', 'alert_schedule', 'alert_start_date');


		$validator = Validator::make($request->only('alert_list_id', 'alert_schedule', 'alert_start_date'),
			[
				'alert_list_id' => 'required',
				'alert_schedule' => 'required',
				'alert_start_date' => 'required',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		Alert::whereId($id)->update($data);

		return redirect()->route('alert.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-alert'))
		{
		     Alert::whereId($id)->delete();
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

		if ($logged_user->can('delete-alert'))
		{

			$alert_id = $request['alertIdArray'];
			$alert = Alert::whereIn('id', $alert_id);
			if ($alert->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.alert')])]);
			}
			else {
				return response()->json(['error' => 'Error selected alerts can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
