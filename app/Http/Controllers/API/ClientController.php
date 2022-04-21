<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Client;
use App\User;
use App\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$data = client::join('projects as p', 'p.id', 'clients.project_id')
				->leftJoin('support_tickets as ot',  function($join)
				{
				  	$join->on('ot.client_id', 'clients.id');
					$join->where('ot.ticket_status','<>', 'completed');
				})
				->leftJoin('support_tickets as ct', function($join)
				{
				  $join->on('ct.client_id', 'clients.id');
				  $join->where('ct.ticket_status', 'completed');
				})
				->select(
					'clients.id as id', 
					'clients.first_name as first_name',
					'clients.contact_no as contact_no',
					'clients.email as email',
					'p.title as title',
					DB::raw('count(ot.id) as open_tickets'),
					DB::raw('count(ct.id) as closed_tickets')

				)
				//->where('ot.ticket_status','<>', 'completed')
				//->where('ct.ticket_status', 'completed')
				->groupBy('clients.id', 
				'clients.first_name',
				'clients.contact_no',
				'clients.email',
				'p.title')
				->get();

		return response()->json($data);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */

	public function store(Request $request)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('store-client'))
		{
			$validator = Validator::make($request->only('username', 'first_name','password', 'contact_no', 'email', 'address1', 'address2',
				'city', 'state', 'country', 'zip', 'profile_photo','project_id'),
				[
					'username' => 'required|unique:users,username,',
					'email' => 'required|email|unique:users',
					'first_name' => 'required',
					'contact_no' => 'nullable|numeric',
					'zip' => 'nullable|numeric',
					'password' => 'required|min:4',
					'profile_photo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
					'project_id' => 'required',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$user_data = [];
			$data = [];

			$user_data['first_name'] = $request->first_name;
			$user_data['username'] = strtolower(trim($request->username));
			$user_data['contact_no'] = $request->contact_no;
			$user_data['email'] = strtolower(trim($request->email));
			$user_data['password'] = bcrypt($request->password);
			$user_data['is_active'] = 1;
			$user_data['role_users_id'] = 3;

			$photo = $request->profile_photo;
			$file_name = null;


			if (isset($photo))
			{
				$new_user = $user_data['username'];
				if ($photo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $photo->getClientOriginalExtension();
					$photo->storeAs('profile_photos', $file_name);
					$user_data['profile_photo'] = $file_name;
					$data ['profile'] = $user_data['profile_photo'];
				}
			}

			$data['first_name'] = $request->first_name;
			$data ['address1'] = $request->address1;
			$data ['address2'] = $request->address2;
			$data ['city'] = $request->city;
			$data ['state'] = $request->state;
			$data ['country'] = $request->country;
			$data ['zip'] = $request->zip;

			$data ['username'] = $user_data['username'];
			$data ['contact_no'] = $user_data['contact_no'];
			$data ['email'] = $user_data['email'];
			$data ['project_id'] = $request->project_id;
			$data['is_active'] = 1;

			$user = User::create($user_data);
			$user->syncRoles(3);

			$data['id'] = $user->id;

			client::create($data);
			

			return response()->json(['success' => __('Data Added successfully.')]);
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
			$data = client::findOrFail($id);

			return response()->json(['data' => $data,'login_type'=> $data->user->login_type]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public function update(Request $request)
	{

		$logged_user = auth()->user();

		if ($logged_user->can('edit-client'))
		{
			$id = $request->hidden_id;

			$client = Client::findOrFail($id);

			$validator = Validator::make($request->only('username', 'first_name', 'contact_no', 'email', 'address1', 'address2',
				'city', 'state', 'country', 'zip', 'profile_photo', 'project_id'),
				[
					'username' => 'required|unique:users,username,' . $id,
					'email' => 'required|email|unique:users,email,' . $id,
					'first_name' => 'required',
					'contact_no' => 'nullable|numeric',
					'zip' => 'nullable|numeric',
					'profile_photo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
					'project_id'  => 'required',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$user_data = [];
			$data = [];

			$user_data['first_name'] = $request->first_name;
			$user_data['username'] = strtolower(trim($request->username));
			$user_data['contact_no'] = $request->contact_no;
			$user_data['email'] = strtolower(trim($request->email));
			$user_data['is_active'] = $request->is_active;


			$photo = $request->profile_photo;
			$file_name = null;


			if (isset($photo))
			{
				$new_user = $user_data['username'];
				if ($photo->isValid())
				{
					if ($client->profile){
						$file_path = public_path('uploads/profile_photos/' . $client->profile);
						if (file_exists($file_path))
						{
							unlink($file_path);
						}
					}
					$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $photo->getClientOriginalExtension();
					$photo->storeAs('profile_photos', $file_name);
					$user_data['profile_photo'] = $file_name;
					$data ['profile'] = $user_data['profile_photo'];
				}
			}

			$data['first_name'] = $request->first_name;
			$data ['address1'] = $request->address1;
			$data ['address2'] = $request->address2;
			$data ['city'] = $request->city;
			$data ['state'] = $request->state;
			$data ['country'] = $request->country;
			$data ['zip'] = $request->zip;

			$data ['username'] = $user_data['username'];
			$data ['contact_no'] = $user_data['contact_no'];
			$data ['email'] = $user_data['email'];
			$data ['project_id'] = $request->project_id;
			$data['is_active'] = $request->is_active;

			try
			{
				User::whereId($id)->update($user_data);

				client::whereId($id)->update($data);
			} catch (Exception $e)
			{
				return response()->json(['error' => trans('file.Error')]);
			}


			return response()->json(['success' => __('Data is successfully updated')]);

		} else
		{
			return response()->json(['success' => __('You are not authorized')]);
		}


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

		if ($logged_user->can('delete-client'))
		{
			$client = Client::findOrFail($id);
			$file_path = $client->profile;

			if ($file_path)
			{
				$file_path = public_path('uploads/profile_photos/' . $file_path);
				if (file_exists($file_path))
				{
					unlink($file_path);
				}
			}

			$client->delete();

			User::whereId($id)->delete();

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

		if ($logged_user->can('delete-client'))
		{
			$client_id = $request['clientIdArray'];
			$clients = Client::whereIn('id', $client_id)->get();

			foreach ($clients as $client)
			{
				$file_path = $client->profile;

				if ($file_path)
				{
					$file_path = public_path('uploads/profile_photos/' . $file_path);
					if (file_exists($file_path))
					{
						unlink($file_path);
					}
				}
				$client->delete();
				User::whereId($client->id)->delete();
			}

			return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Client')])]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}