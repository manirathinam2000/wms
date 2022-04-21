<?php

namespace App\Http\Controllers;

use App\Employee;
use App\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class PaymentStatusController extends Controller
{
	public function index()
	{

		$data = PaymentStatus::latest()->get();
		return view('payment_status.index', compact('data'));

	}

	public function get_data()
	{		
		return datatables()->of(PaymentStatus::latest()->get())->make(true);
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();
		$validator = Validator::make($request->only('payment_status_name'),
			[
				'payment_status_name' => 'required|unique:payment_status,payment_status_name,',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data = [];

		$data['payment_status_name'] = $request->payment_status_name;

		PaymentStatus::create($data);

		return redirect()->route('payment_status.index');
		
	}

	public function create()
	{
		return view('payment_status.create');
	}


	public function edit($id)
	{
		$data = PaymentStatus::findOrFail($id);
		return view('payment_status.edit', compact('data'));
	}

	public function update(Request $request)
	{

		$logged_user = auth()->user();
		
		$id = $request->hidden_id;

		$data = $request->only('payment_status_name');


		$validator = Validator::make($request->only('payment_status_name'),
			[
				'payment_status_name' => 'required|unique:payment_statuss,payment_status_name,' . $id,
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}


		PaymentStatus::whereId($id)->update($data);

		return redirect()->route('payment_status.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-payment_status'))
		{
		     PaymentStatus::whereId($id)->delete();
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

		if ($logged_user->can('delete-payment_status'))
		{

			$payment_status_id = $request['payment_statusIdArray'];
			$payment_status = PaymentStatus::whereIn('id', $payment_status_id);
			if ($payment_status->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.payment_status')])]);
			}
			else {
				return response()->json(['error' => 'Error selected payment_statuss can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
