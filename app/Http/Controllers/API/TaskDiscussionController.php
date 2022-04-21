<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Employee;
use App\Task;
use App\TaskDiscussion;
use Exception;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskDiscussionController extends Controller {

	public function index(Task $task)
	{

		if (request()->ajax())
		{
			return datatables()->of(TaskDiscussion::with('user:id,username')->where('task_id', $task->id)->get())
				->setRowId(function ($discussion)
				{
					return $discussion->id;
				})
				->addColumn('user', function ($row)
				{
					$username = $row->user->username;

					try
					{
						$department_name = Employee::where('employee_id', $row->user->id)->select('department_name')->first();
					} catch (Exception $e)
					{
						$department_name = trans('file.Admin');
					}

					$department_name = empty($department_name) ? '' : $department_name;

					return $username . ' (' . $department_name . ')';

				})
				->addColumn('message', function ($row)
				{
					return $row->task_discussion;
				})
				->addColumn('action', function ($data)
				{

					$button = '<button type="button" name="delete" id="' . $data->id . '" class="delete-discussion btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

					return $button;
				})
				->rawColumns(['action'])
				->make(true);

		}
	}

	public function store(Request $request, Task $task)
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
		$data = [];

		$data['task_discussion'] = $request->get('task_discussions');
		$data['user_id'] = $user->id;
		$data ['task_id'] = $request->id;

		TaskDiscussion::create($data);

		return response()->json([
            'success' => true,
            'message' => 'Data Added Successfully',
            'data' => $data
        ]);
	}

	public function work_details(Request $request)
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

		$user_id =  $user['id'];

		if(!empty($request->id)){
		$user_id =  $request->id;}

		//SupportTicket
		$data = TaskDiscussion::leftJoin('tasks as t', 't.id', 'task_discussions.task_id')
				->leftJoin('projects as p', 'p.id', 't.project_id')
				->select(
					'task_discussions.id as id',
					'task_discussions.task_discussion as task_discussion',
					'task_discussions.created_at as created_at',
					't.task_name as task_name',
					'p.title as project_name'
				)
				->where('task_discussions.user_id', $user_id)->orderBy('created_at', 'desc')
				->get();

		return response()->json($data);
		
	}

	public function project_work_details(Request $request)
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

		//SupportTicket
		$data = TaskDiscussion::leftJoin('tasks as t', 't.id', 'task_discussions.task_id')
				->leftJoin('projects as p', 'p.id', 't.project_id')
				->leftJoin('users as u', 'u.id', 'task_discussions.user_id')
				->select(
					'task_discussions.id as id',
					'task_discussions.task_discussion as task_discussion',
					'task_discussions.created_at as created_at',
					't.task_name as task_name',
					'u.first_name as project_name'
				)
				//->where('task_discussions.user_id', $request->id)
				->orderBy('created_at', 'desc')
				->get();

		return response()->json($data);
		
	}


	public function destroy($id)
	{
		$task = TaskDiscussion::findOrFail($id);

		$task->delete();

		return response()->json(['success' => __('Data is successfully deleted')]);
	}
}
