<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\company;
use App\department;
use App\Employee;
use App\Notifications\TicketCreatedNotification;
use App\Notifications\TicketUpdatedNotification;
use App\SupportTicket;
use App\User;
use DB;
use Exception;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SupportTicketController extends Controller {

	public function index()
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
		$data;
		//SupportTicket

		if($user){
			if($user->role_users_id == 3){
				$data = SupportTicket::where('client_id', $user->id)->orderBy('created_at', 'desc')->get();
			}
		}

		return response()->json($data);
	}

	public function client_tickets(Request $request)
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
		$data = SupportTicket::where('client_id', $request->id)->orderBy('created_at', 'desc')->get();

		return response()->json($data);
		
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
		$validator = Validator::make($request->all(), [
            'description' => 'required|string',
        ]);

		if ($validator->fails()) {
            //return response()->json($validator->errors(), 422);
            return response()->json([
                'success' => false,
                'message' => 'Invalid Question',
            ], 401);
        }

		if(isset($_GET['token'])){
			$token = $_GET['token'];
			try {
				$user = JWTAuth::parseToken()->authenticate();
			} catch (JWTException $exception) {
				return response()->json([
					'success' => false,
					'message' => 'Invalid User',
				], 401);
			}
		}
		else{
			return response()->json([
				'success' => false,
				'message' => 'Invalid User',
			], 401);
		}

		$data = [];

		$data['ticket_code'] = $this->ticketId();
		$data['client_id'] = $user->id;
		$data ['description'] = $request->description;
		$data ['ticket_status'] = 'pending';

		$ticket = SupportTicket::create($data);

		/*if ($ticket->ticket_status == 'open')
		{
			$notificable = User::where('role_users_id', 1)
				->orWhere('id', $data['employee_id'])
				->get();

			Notification::send($notificable, new TicketCreatedNotification($ticket));
		}*/

		return response()->json([
			'success' => true,
			'message' => 'Data added Sucessfully',
			'data' => $ticket,
		], 200);
	}

	public function ticketId()
	{
		$unique = Str::random(8);

		$check = SupportTicket::where('ticket_code', $unique)->first();

		if ($check)
		{
			return $this->ticketId();
		}

		return $unique;
	}

	public function show(SupportTicket $ticket)
	{

		try
		{
			$name = DB::table('employee_support_ticket')->where('support_ticket_id', $ticket->id)->pluck('employee_id')->toArray();
		} catch (Exception $e)
		{
			$name = null;
		}

		$logged_user = auth()->user();

		if ($logged_user->can('view-ticket') || in_array($logged_user->id, $name))
		{

			$employees = DB::table('employees')
				->select('employees.id', DB::raw("CONCAT(employees.first_name,' ',employees.last_name) as full_name"))
				->get();



			return view('SupportTicket.details', compact('ticket', 'employees', 'name'));
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = SupportTicket::findOrFail($id);
			$departments = department::select('id', 'department_name')
				->where('company_id', $data->company_id)->get();

			$employees = Employee::select('id', 'first_name', 'last_name')->where('department_id', $data->department_id)->get();

			return response()->json(['data' => $data, 'employees' => $employees, 'departments' => $departments]);
		}
	}

	/**d
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-ticket'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('subject', 'company_id', 'department_id', 'employee_id', 'ticket_priority', 'description', 'ticket_note'
			),
				[
					'subject' => 'required',
					'company_id' => 'required',
					'department_id' => 'required',
					'employee_id' => 'required',
					'ticket_priority' => 'required',
				]
//				,
//				[
//					'subject.required' => 'Subject can not be empty',
//							]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['subject'] = $request->subject;
			$data ['description'] = $request->description;
			$data ['ticket_note'] = $request->ticket_note;


			$data['employee_id'] = $request->employee_id;

			$data ['company_id'] = $request->company_id;

			$data['department_id'] = $request->department_id;

			$data['ticket_priority'] = $request->ticket_priority;


			SupportTicket::whereId($id)->update($data);
			$ticket = SupportTicket::findOrFail($id);
			$employee = $ticket->employee;

			$notificable = User::where('role_users_id', 1)
				->orWhere('id', $employee->id)
				->get();

			Notification::send($notificable, new TicketUpdatedNotification($ticket));


			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-ticket'))
		{
			$ticket = SupportTicket::findOrFail($id);
			$file_path = $ticket->ticket_attachment;

			if ($file_path)
			{
				$file_path = public_path('uploads/ticket_attachments/' . $file_path);
				if (file_exists($file_path))
				{
					unlink($file_path);
				}
			}

			$ticket->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
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

		if ($logged_user->can('delete-ticket'))
		{
			$ticket_id = $request['ticketIdArray'];
			$tickets = SupportTicket::whereIn('id', $ticket_id)->get();

			foreach ($tickets as $ticket)
			{
				$file_path = $ticket->ticket_attachment;

				if ($file_path)
				{
					$file_path = public_path('uploads/ticket_attachments/' . $file_path);
					if (file_exists($file_path))
					{
						unlink($file_path);
					}
				}
				$ticket->delete();
			}

			return response()->json(['success' => __('Multi Delete', ['key' => __('Support Ticket')])]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function download($id)
	{

		$file = SupportTicket::findOrFail($id);

		$file_path = $file->ticket_attachment;

		$download_path = public_path("uploads/ticket_attachments/" . $file_path);

		if (file_exists($download_path))
		{
			$response = response()->download($download_path);

			return $response;
		} else
		{
			return abort('404', __('File not Found'));
		}
	}


	public function detailsStore(Request $request, SupportTicket $ticket)
	{
			$validator = Validator::make($request->only('ticket_remarks', 'ticket_status'),
				[
					'ticket_remarks' => 'required',
					'ticket_status' => 'required',
				]
//				,
//				[
//					'ticket_remarks.required' => 'Remarks can not be empty',
//					'ticket_status.required' => 'Please select a status',
//						]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['ticket_remarks'] = $request->ticket_remarks;
			$data['ticket_status'] = $request->ticket_status;

			$ticket->update($data);

			$assigned = $ticket->assignedEmployees()->get();

			$notificable = User::where('role_users_id', 1)
				->orWhere('id', $ticket->employee->id)
				->get();

			Notification::send($notificable, new TicketUpdatedNotification($ticket));

			if (sizeof($assigned) == 0)
			{
				Notification::send($assigned, new TicketUpdatedNotification($ticket));
			}

			return response()->json(['success' => 'Data Updated successfully.', 'ticket' => $ticket]);
		}


	public function notesStore(Request $request, SupportTicket $ticket)
	{
		$validator = Validator::make($request->only('ticket_note'),
			[
				'ticket_note' => 'required',
			]
//				,
//				[
//					'ticket_note.required' => 'Note can not be empty',
//				]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}


		$data = [];

		$data['ticket_note'] = $request->ticket_note;

		$ticket->update($data);

		return response()->json(['success' => 'Data Updated successfully.', 'ticket' => $ticket]);
	}

}