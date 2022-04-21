<?php

namespace App\Http\Controllers;

use App\Employee;
use App\FuelCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class FuelCardController extends Controller
{
	public function index()
	{
		$data = FuelCard::latest()->get();

		return view('fuel_card.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(FuelCard::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('fuel_card_number', 'fuel_card_company', 'limits' , 'expiry'),
				[
					'fuel_card_number' => 'required|unique:fuel_cards,fuel_card_number,',
					'fuel_card_company' => 'required',
					'limits'=> 'required', 
					'expiry'=> 'required', 
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['fuel_card_number'] = $request->fuel_card_number;
			$data ['fuel_card_company'] = $request->fuel_card_company;
			$data ['limits'] = $request->limits;
			$data ['expiry'] = $request->expiry;


			FuelCard::create($data);

			return redirect()->route('fuel_card.index');
		
	}

	public function create()
	{
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$task_types = \DB::table('task_types')->select('id','task_type_name')->get();
		return view('fuel_card.create', compact( 'locations', 'task_types'));
	}


	public function edit($id)
	{

			$data = FuelCard::findOrFail($id);
			return view('fuel_card.edit', compact('data'));

	}






	public function update(Request $request)
	{

           $id = $request->hidden_id;

			$data = $request->only('fuel_card_number', 'fuel_card_company', 'limits' , 'expiry');

				$validator = Validator::make($request->only('fuel_card_number', 'fuel_card_company', 'limits' , 'expiry'),
				[
					'fuel_card_number' => 'required|unique:fuel_cards,fuel_card_number,' . $id ,
					'fuel_card_company' => 'required',
					'limits'=> 'required', 
					'expiry'=> 'required', 
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			FuelCard::whereId($id)->update($data);

			return redirect()->route('fuel_card.index');

	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-fuel_card'))
		{
		     FuelCard::whereId($id)->delete();
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

		if ($logged_user->can('delete-fuel_card'))
		{

			$fuel_card_id = $request['fuel_cardIdArray'];
			$fuel_card = FuelCard::whereIn('id', $fuel_card_id);
			if ($fuel_card->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.fuel_card')])]);
			}
			else {
				return response()->json(['error' => 'Error selected fuel_cards can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
