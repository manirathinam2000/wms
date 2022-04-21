<?php

namespace App\Http\Controllers;

use App\Employee;
use App\PurchaseOrderBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class PurchaseOrderBookingController extends Controller
{
	public function index()
	{
		$data = PurchaseOrderBooking::latest()->get();

		return view('purchase_order_booking.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(PurchaseOrderBooking::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('vendor_invoice_number', 'invoice_date', 'invoice_amount'),
				[
					'vendor_invoice_number' => 'required|unique:purchase_order_bookings,vendor_invoice_number,',
					'invoice_date' => 'required',
					'invoice_amount'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['vendor_invoice_number'] = $request->vendor_invoice_number;
			$data['invoice_date'] = $request->invoice_date;
			$data ['invoice_amount'] = $request->invoice_amount;
			$data ['submitted_date'] = $request->submitted_date;
			$data ['goods_receipt'] = $request->goods_receipt;
			$data ['payment_status_id'] = $request->payment_status_id;
			$data ['payment_date'] = $request->payment_date;

			PurchaseOrderBooking::create($data);


			return redirect()->route('purchase_order_booking.index');
		
	}

	public function create()
	{
		$payment_status = \DB::table('payment_status')->select('id','payment_status_name')->get();
		return view('purchase_order_booking.create', compact( 'payment_status'));
	}


	public function edit($id)
	{
		$payment_status = \DB::table('payment_status')->select('id','payment_status_name')->get();
		$data = PurchaseOrderBooking::findOrFail($id);
		return view('purchase_order_booking.edit', compact('data', 'payment_status'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('vendor_invoice_number','invoice_date','invoice_amount','submitted_date','goods_receipt','payment_status_id','payment_date');

			$validator = Validator::make($request->only('vendor_invoice_number', 'invoice_date', 'invoice_amount'),
			[
				'vendor_invoice_number' => 'required|unique:purchase_order_bookings,vendor_invoice_number,' . $id,
				'invoice_date' => 'required',
				'invoice_amount'=> 'required'
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

			PurchaseOrderBooking::whereId($id)->update($data);

			return redirect()->route('purchase_order_booking.index');
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-purchase_order_booking'))
		{
		     PurchaseOrderBooking::whereId($id)->delete();
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

		if ($logged_user->can('delete-purchase_order_booking'))
		{

			$purchase_order_booking_id = $request['purchase_order_bookingIdArray'];
			$purchase_order_booking = PurchaseOrderBooking::whereIn('id', $purchase_order_booking_id);
			if ($purchase_order_booking->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.purchase_order_booking')])]);
			}
			else {
				return response()->json(['error' => 'Error selected purchase_order_bookings can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
