<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Attendance;
use App\Project;
use App\Task;
use App\Client;
use DB;
use Exception;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$user = '';
		if(isset($_GET['token'])){
			$token = $_GET['token'];
			try {
				$user = JWTAuth::parseToken()->authenticate();
			} catch (JWTException $exception) {
				//pass
			}
		}
		if($user){
            $data = Attendance::where('employee_id', $user->id)->where('attendance_date', $request->currentDate)->first();

		}
		if(!empty($data)){
			$data_val = 1;
            return response()->json([
                'success' => true,
                'message' => 'Logged In',
                'data' => $data_val
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Not Logged in',
            'data' => 0
        ]);

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$user = '';
		if(isset($_GET['token'])){
			$token = $_GET['token'];
			try {
				$user = JWTAuth::parseToken()->authenticate();
			} catch (JWTException $exception) {
				//pass
			}
		}

        $data['employee_id'] = $user->id;
		$data['attendance_date'] = $request->currentDate;
        $data['attendance_status'] = 'present';
		$data['latitude'] = $request->latitude;
		$data['longitude'] = $request->longitude;
        $data['clock_in'] = date('H:i');

        Attendance::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data Added Successfully',
            'data' => 1
        ]);

	}

	public function edit(Request $request)
	{
		if(isset($_GET['token'])){
			$token = $_GET['token'];
			try {
				$user = JWTAuth::parseToken()->authenticate();
			} catch (JWTException $exception) {
				//pass
			}
		}

		$data = Attendance::where('employee_id', $user->id)->where('attendance_date', $request->currentDate)->first();

		$data['clock_out'] = date('H:i');
		$data->save();

		
		return response()->json([
            'success' => true,
            'message' => 'Data Added Successfully',
            'data' => 2
        ]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param Project $task
	 * @return Response
	 */
	public function show(Task $task)
	{

		$company_name = $task->company->company_name ?? '';

		try
		{
			$name = DB::table('employee_task')->where('task_id', $task->id)->pluck('employee_id')->toArray();
		} catch (Exception $e)
		{
			$name = null;
		}
		$logged_user = auth()->user();

		if ($logged_user->can('view-task') || in_array($logged_user->id, $name))
		{

			$employees = DB::table('employees')->where('company_id', $task->company_id)
				->select('employees.id', DB::raw("CONCAT(employees.first_name,' ',employees.last_name) as full_name"))
				->get();

			return view('projects.task.details', compact('task', 'employees', 'company_name', 'name'));
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Project $task
	 * @return Response
	 */
	public function edits($id)
	{
		if (request()->ajax())
		{
			$data = Task::findOrFail($id);

			return response()->json(['data' => $data]);
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param Project $task
	 * @return Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('edit-task'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('edit_task_name', 'edit_project_id', 'edit_description', 'edit_start_date'
				, 'edit_end_date', 'edit_task_status', 'edit_task_progress'),
				[
					'edit_task_name' => 'required',
					'edit_project_id' => 'required',
					'edit_start_date' => 'required',
					'edit_end_date' => 'required',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['task_name'] = $request->edit_task_name;
			$data['project_id'] = $request->edit_project_id;
			$data ['start_date'] = $request->edit_start_date;
			$data ['end_date'] = $request->edit_end_date;

			if ($request->edit_description)
			{
				$data ['description'] = $request->edit_description;
			}

			$data ['task_hour'] = $request->edit_task_hour;
			$data ['task_status'] = $request->edit_task_status;
			if ($request->edit_task_progress)
			{
				$data ['task_progress'] = $request->edit_task_progress;
			}


			Task::find($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Project $task
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-task'))
		{
			Task::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	public function progressStore(Request $request, Task $task)
	{
			$validator = Validator::make($request->only('task_hour'),
				[
					'task_hour' => 'required|numeric',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			if ($request->task_progress)
			{
				$data['task_progress'] = $request->task_progress;
			}
			$data['task_hour'] = $request->task_hour;

			if ($request->task_status)
			{
				$data['task_status'] = $request->task_status;
			}


			$task->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}


	public function notesStore(Request $request, Task $task)
	{
		$validator = Validator::make($request->only('task_note'),
			[
				'task_note' => 'required',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}


		$data = [];

		$data['task_note'] = $request->task_note;

		$task->update($data);

		return response()->json(['success' => __('Data is successfully updated')]);
	}
}
