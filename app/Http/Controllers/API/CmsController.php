<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\AboutInfo;
use App\CMS;
use Illuminate\Http\Request;


class CmsController extends Controller
{
	public function index()
	{
		$cms = CMS::find(1);

		return response()->json([
			'success' => true, 
			'message' => 'Date feteched successfully!',
			'data' 	  => $cms
		]);
	}

	public function store(Request $request)
	{


		$data1 = [];
		$data2 = [];
		$data3 = [];

		$data1['home'] = $request->home;
		$data2['about'] = $request->about;
		$data3['contact'] = $request->contact;

		CMS::updateOrCreate(['id'=>1],$data1);
		CMS::updateOrCreate(['id'=>1],$data2);

		CMS::updateOrCreate(['id'=>1],$data3);


		return redirect()->back()->with('message', 'Data updated successfully');
	}

}
