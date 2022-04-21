<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class VehicleController extends Controller
{
	public function index()
	{
		$data = Vehicle::latest()->get();

		return view('vehicle.index', compact('data'));
	}

	public function get_data()
	{
		
			return datatables()->of(Vehicle::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('vehicle_registration_number', 'vin', 'engine_no'),
				[
					'vin' => 'required|unique:vehicles,vin,',
					'vehicle_registration_number' => 'required',
					'engine_no'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['vehicle_registration_number'] = $request->vehicle_registration_number;
			$data['sufix'] = $request->sufix;
			$data ['description'] = $request->description;
			$data ['model_id'] = $request->model_id;
			$data ['vin'] = $request->vin;
			$data ['engine_no'] = $request->engine_no;
			$data ['engine'] = $request->engine;
			$data ['color'] = $request->color;
			$data ['trims'] = $request->trims;
			$data ['std_fitment'] = $request->std_fitment;
			$data ['reg_type'] = $request->reg_type;
			$data ['category_type_id'] = $request->category_type_id;
			$data ['category_id'] = $request->category_id;
			$data ['key_no'] = $request->key_no;
			$data ['customer_name'] = $request->customer_name;
			$data ['owner_name'] = $request->owner_name;
			$data ['remarks'] = $request->remarks;
			if(isset($request->active_status))
				$data ['active_status'] = 1;
			else
				$data ['active_status'] = 0;
			$data ['amc_status'] = $request->amc_status;
			$data ['registration_expiry'] = $request->registration_expiry;
			$data ['insurance_policy_number'] = $request->insurance_policy_number;
			$data ['premium_amount'] = $request->premium_amount;
			$data ['insurance_expiry'] = $request->insurance_expiry;
			$data ['purchase_date'] = $request->purchase_date;
			$data ['purchase_cost'] = $request->purchase_cost;
			$data ['asset_structure'] = $request->asset_structure;
			$data ['fuel_card_number_id'] = $request->fuel_card_number_id;
			$data['column1'] = $request->column1;
			$data['column2'] = $request->column2;
			$data['column3'] = $request->column3;
			$data['column4'] = $request->column4;
			$data['column5'] = $request->column5;

			$file_1 = $request->file_1;
			$file_name = null;

			if (isset($file_1))
			{
				$vin = $request->vin;
				if ($file_1->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $vin) . '_1_' . time() . '.' . $file_1->getClientOriginalExtension();
					$file_1->storeAs('uploaded_file', $file_name);
					$data['file_1'] = $file_name;
				}
			}

			$file_2 = $request->file_2;
			$file_name = null;


			if (isset($file_2))
			{
				$vin = $request->vin;
				if ($file_2->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $vin) . '_2_' . time() . '.' . $file_2->getClientOriginalExtension();
					$file_2->storeAs('uploaded_file', $file_name);
					$data['file_2'] = $file_name;
				}
			}

			Vehicle::create($data);


			return redirect()->route('vehicle.index');
		
	}

	public function create()
	{
		$models = \DB::table('vehicle_models')->select('id','vehicle_model_name')->get();
		$types = \DB::table('vehicle_types')->select('id','vehicle_type_name')->get();
		$categorys = \DB::table('vehicle_category')->select('id','vehicle_category_name')->get();
		$cards = \DB::table('fuel_cards')->select('id','fuel_card_number')->get();
		return view('vehicle.create', compact( 'models', 'types', 'categorys', 'cards'));
	}


	public function edit($id)
	{
		$models = \DB::table('vehicle_models')->select('id','vehicle_model_name')->get();
		$types = \DB::table('vehicle_types')->select('id','vehicle_type_name')->get();
		$categorys = \DB::table('vehicle_category')->select('id','vehicle_category_name')->get();
		$cards = \DB::table('fuel_cards')->select('id','fuel_card_number')->get();
		$data = Vehicle::findOrFail($id);
		return view('vehicle.edit', compact('data', 'models', 'types', 'categorys', 'cards'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('vehicle_registration_number','sufix','description','model_id','vin','engine_no','engine','color','trims', 'std_fitment', 'reg_type', 'category_type_id', 'category_id', 'key_no', 'customer_name', 'owner_name', 'remarks', 'active_status', 'amc_status', 'registration_expiry', 'insurance_policy_number', 'premium_amount', 'insurance_expiry', 'purchase_date', 'purchase_cost', 'asset_structure', 'fuel_card_number_id', 'column1', 'column2', 'column3', 'column4', 'column5');

				if(isset($request->active_status))
				$data ['active_status'] = 1;
			else
				$data ['active_status'] = 0;

				$validator = Validator::make($request->only('vehicle_registration_number', 'vin', 'engine_no'),
				[
					'vin' => 'required|unique:vehicles,vin,' . $id,
					'vehicle_registration_number' => 'required',
					'engine_no'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			Vehicle::whereId($id)->update($data);

			return redirect()->route('vehicle.index');
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-vehicle'))
		{
		     Vehicle::whereId($id)->delete();
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

		if ($logged_user->can('delete-vehicle'))
		{

			$vehicle_id = $request['vehicleIdArray'];
			$vehicle = Vehicle::whereIn('id', $vehicle_id);
			if ($vehicle->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.vehicle')])]);
			}
			else {
				return response()->json(['error' => 'Error selected vehicles can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
