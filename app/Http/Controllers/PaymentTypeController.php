<?php

namespace App\Http\Controllers;

use App\Employee;
use App\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class PaymentTypeController extends Controller
{
	public function index()
	{
		$data = PaymentType::latest()->get();

		return view('payment_type.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(PaymentType::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('payment_type_name'),
				[
					'payment_type_name' => 'required|unique:payment_types,payment_type_name,',
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['payment_type_name'] = $request->payment_type_name;

			PaymentType::create($data);

			return redirect()->route('payment_type.index');
		
	}

	public function create()
	{
		return view('payment_type.create');
	}


	public function edit($id)
	{

			$data = PaymentType::findOrFail($id);
			return view('payment_type.edit', compact('data'));

	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();


           $id = $request->hidden_id;

			$data = $request->only('payment_type_name');

				$validator = Validator::make($request->only('payment_type_name'),
				[
					'payment_type_name' => 'required|unique:payment_types,payment_type_name,' . $id,
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			PaymentType::whereId($id)->update($data);

			return redirect()->route('payment_type.index');
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-payment_type'))
		{
		     PaymentType::whereId($id)->delete();
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

		if ($logged_user->can('delete-payment_type'))
		{

			$payment_type_id = $request['payment_typeIdArray'];
			$payment_type = PaymentType::whereIn('id', $payment_type_id);
			if ($payment_type->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.payment_type')])]);
			}
			else {
				return response()->json(['error' => 'Error selected payment_types can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
