<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Inspection;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class JobCardController extends Controller
{
	public function index()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$data = Inspection::where('id', '<', '0')->get();

		return view('job_card.index', compact('data', 'countries'));
	}

	public function get_data()
	{
		
			return datatables()->of(Part::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



		$validator = Validator::make($request->only('date_time', 'service_category_id', 'customer_id'),
			[
				'date_time' => 'required',
				'service_category_id' => 'required',
				'customer_id' => 'required',
			]
		);

		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		$data_job = new Job;

		$data_job['job_type_id'] = 1;
		$data_job['customer_id'] = $request->customer_id;
		$data_job['service_category_id'] = $request->service_category_id;

		$data_job->save();

		$data = new Inspection;

			$data['job_id'] = $data_job->id;
			$data['ref_no'] = $request->ref_no;
			$data['date_time'] = $request->date_time;
			$data ['mileage'] = $request->mileage;
			$data ['odometer'] = $request->odometer;
			$data ['fuel'] = $request->fuel;
			$data ['service_book'] = $request->service_book;
			$data ['radio'] = $request->radio;
			$data ['wipers'] = $request->wipers;
			$data ['air_conditioner'] = $request->air_conditioner;
			$data ['spare_wheel'] = $request->spare_wheel;
			$data ['cassette'] = $request->cassette;
			$data ['cig_lighter'] = $request->cig_lighter;
			$data['head_rest'] = $request->head_rest;
			$data['jack'] = $request->jack;
			$data['antenna'] = $request->antenna;
			$data['wheel_cap'] = $request->wheel_cap;
			$data['tools'] = $request->tools;
			$data['front_left'] = $request->front_left;
			$data['front_right'] = $request->front_right;
			$data['rear_left'] = $request->rear_left;
			$data['rear_right'] = $request->rear_right;
			$data['head_light'] = $request->head_light;
			$data['front_park_light'] = $request->front_park_light;
			$data['rear_red_light'] = $request->rear_red_light;
			$data['turn_signals'] = $request->turn_signals;
			$data['fire_extinguisher'] = $request->fire_extinguisher;
			$data['inside_mirror'] = $request->inside_mirror;
			$data['mirror_lh'] = $request->mirror_lh;
			$data['mirror_lh'] = $request->mirror_lh;


				$data->save();


			return redirect()->route('inspection.edit', ['id' => $data->id]);
		
	}

	public function create()
	{
		$service_categories = \DB::table('service_category')->select('id','service_category_name')->get();
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$customers = \DB::table('vehicles')->select('id','customer_name')->get();
		$categorys = \DB::table('part_category')->select('id','part_category_name')->get();
		$types = \DB::table('part_type')->select('id','part_type_name')->get();
		return view('inspection.create', compact('service_categories', 'customers'));
	}


	public function edit($id)
	{
		$service_categories = \DB::table('service_category')->select('id','service_category_name')->get();
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$customers = \DB::table('vehicles')->select('id','customer_name')->get();
		$data = Inspection::leftjoin('jobs as j', 'j.id', 'inspections.job_id')
					->where('inspections.id', $id)->first();
		return view('inspection.edit', compact('data', 'service_categories', 'customers'));
	}

	public function update(Request $request)
	{

		$id = $request->hidden_id;

		$data = $request->only('ref_no','date_time','job_id','location_id','is_billing','service_book','spare_wheel','jack','radio', 'cassette', 'antenna', 'wipers', 'cig_lighter', 'wheel_cap', 'air_conditioner', 'head_rest', 'tools', 'front_left', 'front_right', 'rear_left', 'rear_right', 'head_light', 'front_park_light', 'rear_red_light', 'turn_signals', 'fire_extinguisher', 'inside_mirror',  'mirror_lh', 'mileage', 'odometer', 'mirror_rh', 'is_approved', 'fuel');

		$validator = Validator::make(
			$request->only('date_time', 'service_category_id', 'customer_id'),
			[
				'date_time' => 'required',
				'service_category_id' => 'required',
				'customer_id' => 'required',
			]
		);

		if ($validator->fails())
		{
			return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
		}

		//dd($data);
		Inspection::whereId($id)->update($data);

		return redirect()->route('inspection.task', ['id' => $id]);
	}


	public function task_add($id)
	{
		$task_types = \DB::table('task_types')->select('id','task_type_name')->get();
		$parts = \DB::table('parts')->select('id','part_name')->where('id', '<', '0')->get();
		$data = Inspection::findOrFail($id);
		return view('inspection.task_add', compact('data', 'parts', 'task_types'));
	}

	public function task_store(Request $request)
	{

		$inventory_id = $request->hidden_id;

		$validator = Validator::make($request->only('parts_id', 'quantity', 'standard_time'),
				[
					'parts_id' => 'required',
					'standard_time' => 'required',
					'quantity' => 'required|numeric',
				]
			);

			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			$data = new InventoryDetail;

			$data->inventory_id = $inventory_id;
			$data->parts_id = $request->parts_id;
			$data->quantity = $request->quantity;
			$data->is_active = 1;

			$data->save();

			return redirect()->route('inventory.transfer.edit', ['id'=>$data->inventory_id]);
		
	}

	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-part'))
		{
		     Part::whereId($id)->delete();
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

		if ($logged_user->can('delete-part'))
		{

			$part_id = $request['partIdArray'];
			$part = Part::whereIn('id', $part_id);
			if ($part->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.part')])]);
			}
			else {
				return response()->json(['error' => 'Error selected parts can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
