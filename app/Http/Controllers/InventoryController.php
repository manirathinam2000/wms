<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Employee;
use App\Manufacture;
use App\Part;
use App\Inventory;
use App\InventoryDetail;



class InventoryController extends Controller
{
	public function index()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$data = InventoryDetail::leftJoin('parts as p', 'p.id', 'inventory_details.parts_id')
					->leftJoin('locations as l', 'l.id', 'p.location_id')
					->select(
						'p.id',
						'p.part_name',
						'l.location_name',
						DB::raw('sum(inventory_details.quantity) as stock')
					)
					->where('p.is_active', '2')->get();

		return view('inventory.index', compact('data', 'countries'));
	}

	public function get_data()
	{
		
			return datatables()->of(Manufacture::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('branch', 'requisition_no', 'type',
				 'po_no'),
				[
					'branch' => 'required',
					'requisition_no' => 'required',
					'type'=> 'required',
					'po_no'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

/*
			$data = [];

			$data['manufacture_name'] = $request->manufacture_name;
			$data['sap_ref_code'] = $request->sap_ref_code;
			$data ['address1'] = $request->address1;
			$data ['address2'] = $request->address2;
			$data ['city'] = $request->city;
			$data ['country'] = $request->country;
			$data ['contact_person'] = $request->contact_person;
			$data ['mobile'] = $request->mobile;
			$data ['email'] = $request->email;
			if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;

			Manufacture::create($data);
*/

			return redirect()->route('inventory.create');
		
	}

	public function create()
	{
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$types = \DB::table('part_type')->select('id','part_type_name')->get();
		$orders = \DB::table('purchase_order_bookings')->select('id')->get();
		return view('inventory.create', compact( 'locations', 'types', 'orders'));
	}


	public function edit()
	{
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$types = \DB::table('part_type')->select('id','part_type_name')->get();
		$orders = \DB::table('purchase_order_bookings')->select('id')->get();
		return view('inventory.create', compact( 'locations', 'types', 'orders'));
	}

	public function transfer_index()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$data = Inventory::leftJoin('locations as l', 'l.id', 'inventories.branch_id')
					->leftJoin('locations as l2', 'l2.id', 'inventories.to_branch_id')
					->select('inventories.*', 'l.location_name', 'l2.location_name as to_location_name')
					->get();

		return view('inventory.transfer.index', compact('data', 'countries'));
	}

	public function transfer_create()
	{
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$inventory['id'] = 0;
		return view('inventory.transfer.create', compact( 'locations'));
	}

	public function transfer_store(Request $request)
	{
		$validator = Validator::make($request->only('branch_id', 'to_branch_id'),
				[
					'branch_id' => 'required',
					'to_branch_id' => 'required',
				]
			);

			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			$data = new Inventory;

			$data->branch_id = $request->branch_id;
			$data->to_branch_id = $request->to_branch_id;
			$data->type_id = 3;
			$data->trans_date = date('Y-m-d');
			$data->is_active = 1;

			$data->save();

			return redirect()->route('inventory.transfer.products', ['id'=>$data->id]);
		
	}

	public function transfer_products_add($id)
	{
		$parts = \DB::table('parts')->select('id','part_name')->where('id', '<', '0')->get();
		$data = Inventory::findOrFail($id);
		return view('inventory.transfer.products_add', compact('data', 'parts'));
	}

	public function transfer_product_store(Request $request)
	{

		$inventory_id = $request->hidden_id;

		$validator = Validator::make($request->only('parts_id', 'quantity'),
				[
					'parts_id' => 'required',
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

	public function transfer_edit($id)
	{
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$data = Inventory::findOrFail($id);
		$products = InventoryDetail::leftJoin('parts as p', 'p.id', 'inventory_details.parts_id')
						->where('inventory_id', $data->id)->get();
		return view('inventory.transfer.edit', compact('data', 'locations', 'products'));	
	}





	public function update(Request $request)
	{

		$logged_user = auth()->user();
/*
           $id = $request->hidden_id;

			$data = $request->only('manufacture_name','sap_ref_code','address1','address2','city','country','contact_person','mobile','email', 'is_active');

				if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;
*/
				$validator = Validator::make($request->only('branch', 'requisition_no', 'type',
				 'po_no'),
				[
					'branch' => 'required',
					'requisition_no' => 'required',
					'type'=> 'required',
					'po_no'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}

			// Manufacture::whereId($id)->update($data);

			return redirect()->route('inventory.create');
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-manufacture'))
		{
		     Manufacture::whereId($id)->delete();
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

		if ($logged_user->can('delete-manufacture'))
		{

			$manufacture_id = $request['manufactureIdArray'];
			$manufacture = Manufacture::whereIn('id', $manufacture_id);
			if ($manufacture->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.manufacture')])]);
			}
			else {
				return response()->json(['error' => 'Error selected manufactures can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
