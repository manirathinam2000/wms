<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class PartController extends Controller
{
	public function index()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$data = Part::leftJoin('locations as l', 'l.id', 'parts.location_id')->get();

		return view('part.index', compact('data', 'countries'));
	}

	public function get_data()
	{
		
			return datatables()->of(Part::latest()->get())
				
				->make(true);
		
	}


	public function store(Request $request)
	{

		

		$logged_user = auth()->user();



			$validator = Validator::make($request->only('part_name', 'oem_part_number', 'selling_price',
				 'purchase_price'),
				[
					'part_name' => 'required|unique:parts,part_name,',
					'oem_part_number' => 'required',
					'purchase_price'=> 'required', 
					'selling_price'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			$data = [];

			$data['part_name'] = $request->part_name;
			$data['article_number'] = $request->article_number;
			$data ['oem_part_number'] = $request->oem_part_number;
			$data ['part_description'] = $request->part_description;
			$data ['make'] = $request->make;
			$data ['model'] = $request->model;
			$data ['type_id'] = $request->type_id;
			$data ['category_id'] = $request->category_id;
			$data ['uom_id'] = $request->uom_id;
			$data ['purchase_price'] = $request->purchase_price;
			$data ['selling_price'] = $request->selling_price;
			$data ['max_discount'] = $request->max_discount;
			$data ['reorder_level'] = $request->reorder_level;
			$data ['location_id'] = $request->location_id;
			$data['column1'] = $request->column1;
			$data['column2'] = $request->column2;
			$data['column3'] = $request->column3;
			$data['column4'] = $request->column4;
			$data['column5'] = $request->column5;

			if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;

			Part::create($data);


			return redirect()->route('part.index');
		
	}

	public function create()
	{
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$uoms = \DB::table('uom')->select('id','uom')->get();
		$categorys = \DB::table('part_category')->select('id','part_category_name')->get();
		$types = \DB::table('part_type')->select('id','part_type_name')->get();
		return view('part.create', compact('types', 'categorys', 'uoms', 'locations'));
	}


	public function edit($id)
	{
		$locations = \DB::table('locations')->select('id','location_name')->get();
		$uoms = \DB::table('uom')->select('id','uom')->get();
		$categorys = \DB::table('part_category')->select('id','part_category_name')->get();
		$types = \DB::table('part_type')->select('id','part_type_name')->get();
		$data = Part::findOrFail($id);
		return view('part.edit', compact('data', 'types', 'categorys', 'uoms', 'locations'));
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

           $id = $request->hidden_id;

			$data = $request->only('part_name','article_number','oem_part_number','part_description','make','model','type_id','category_id','uom_id', 'purchase_price', 'selling_price', 'max_discount', 'reorder_level', 'location_id', 'is_active', 'column1', 'column2', 'column3', 'column4', 'column5');

				if(isset($request->is_active))
				$data ['is_active'] = 1;
			else
				$data ['is_active'] = 0;

				$validator = Validator::make($request->only('part_name', 'oem_part_number', 'selling_price',
				 'purchase_price'),
				[
					'part_name' => 'required|unique:parts,part_name,' . $id,
					'oem_part_number' => 'required',
					'purchase_price'=> 'required', 
					'selling_price'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return redirect()->back()->withErrors([$validator->errors()->all()])->withInput();
			}


			Part::whereId($id)->update($data);

			return redirect()->route('part.index');
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
